<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\v1\RegisterResource;
use App\Models\DeliveryBoyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function action(Request $request)
    {
        $validator = new RegisterRequest();

        $rules = $validator->rules();
        if ($request->get('role') == 3 || $request->get('role') == 4) {
            $rules['deposit_amount'] = 'nullable|numeric';
            $rules['limit_amount']   = 'nullable|numeric';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $role     = Role::find($request->get('role'));

        if (blank($role)) {
            return response()->json([
                'data'    => [],
                'message' => 'You given role not found',
                'status'  => 401,
            ], 401);
        }

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

        $userArray = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $request->get('email'),
            'username'   => $username,
            'phone'      => $request->get('phone'),
            'password'   => bcrypt($request->get('password')),
        ];

        $user     = User::create($userArray);
        $mainuser = User::find($user->id);

        $mainuser->assignRole($role->name);

        if ($request->role == 4) {
            $deliveryBoyAccount                  = new DeliveryBoyAccount();
            $deliveryBoyAccount->user_id         = $mainuser->id;
            $deliveryBoyAccount->delivery_charge = 0;
            $deliveryBoyAccount->balance         = 0;
            $deliveryBoyAccount->save();
        }

        if (!$token = auth()->guard('api')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'data'    => [],
                'message' => 'You try to using invalid username or password',
                'status'  => 401,
            ], 401);
        }
        return (new RegisterResource($mainuser))
            ->additional([
                'token' => $token,
            ], 200);

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
