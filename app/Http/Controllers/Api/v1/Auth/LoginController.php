<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\v1\PrivateUserResource;
use App\Http\Resources\v1\RestaurantResource;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['action']]);
    }

    public function action(LoginRequest $request)
    {
        $token = auth('api')->attempt($request->only('email', 'password'));

        if (!$token) {
            return response()->json([
                'data'    => [],
                'message' => 'You try to using invalid username or password',
                'status'  => 401,
            ], 401);
        }

        $user = auth('api')->user();
        $role = $request->role;
        if ($role == UserRole::WAITER) {
            $restaurant = !blank($user->waiter->restaurant) ? new RestaurantResource($user->waiter->restaurant) : [];
            $waiter = $user->waiter->id;
        } else {
            $restaurant = !blank($user->restaurant) ? new RestaurantResource($user->restaurant) : [];
            $waiter = 0;
        }

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
                'restaurant'  => $restaurant,
                'waiter_id'  => $waiter,
            ]);
    }

}
