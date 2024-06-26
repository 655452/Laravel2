<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\v1\RestaurantResource;
use App\Http\Resources\v1\PrivateUserResource;

class SocialLoginController extends Controller
{

    public function action(Request $request)
    {
        $isUser = User::where('email', '=', $request->email)
            ->first();

        if (!$isUser) {
            $first_name = '';
            $last_name  = '';
            if ($request->has('name')) {
                $parts      = $this->split_name($request->get('name'));
                $first_name = $parts[0];
                $last_name  = $parts[1];
            }

            $username = '';
            if ($request->has('email')) {
                $username = $this->username($request->get('email'));
            }
            $user     = User::create([
                'first_name'        => $first_name,
                'last_name'        => $last_name,
                'email'             => $request->email,
                'email_verified_at' => now(),
                'username'          => $username,
                'password'          => Hash::make('123456'),
                'provider_id'       => $request->provider_id,
                'provider'       => $request->provider,
            ]);

            $role     = Role::find(2);
            $user->assignRole($role->name);

            $token = auth()->guard('api')->attempt(['email'=>$request->email,'password'=>'123456']);
            return (new PrivateUserResource($user))
                ->additional([
                    'token' => $token,
                ]);
        }
        $token = JWTAuth::fromUser($isUser);

        auth()->guard('api')->login($isUser);
        $user = auth('api')->user();
        $role = $request->role;
        if ($user->status == UserStatus::INACTIVE) {
            auth('api')->logout();
            return response()->json([
                'data'    => [],
                'message' => 'Your account currently inactive. you can\'t login our system.',
                'status'  => 401,
            ], 401);
        }

        if ($role && ($role != $user->myrole)) {
            return response()->json([
                'data'    => [],
                'message' => "You don't have permission to login",
                'status'  => 401,
            ], 401);
        }

        return (new PrivateUserResource($user))
            ->additional([
                'token' => $token,
            ]);
    }

    private function split_name($name)
    {
        $name       = trim($name);
        $last_name  = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return [$first_name, $last_name];
    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }
}
