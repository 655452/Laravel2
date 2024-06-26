<?php

/**
 * Created by PhpStorm.
 * User: Dipok Hlader
 * Date: 7/14/20
 * Time: 6:18 PM
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Otp;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\v1\ShopResource;
use Illuminate\Support\Facades\Validator;
use App\Notifications\OneTimePasswordSend;
use App\Http\Resources\v1\RestaurantResource;
use App\Http\Resources\v1\PrivateUserResource;

class OtpLoginController extends Controller
{

    public function getOtp(Request $request)
    {

        $email = false;
        $phone = false;

        $requestArray = [
            'otp' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $requestArray);

        if (!blank($request->otp)) {
            if (filter_var($request->otp, FILTER_VALIDATE_EMAIL)) {
                $email = true;
            } else {
                $phone = true;
            }
        }

        $queryArray = [];
        if ($email) {
            $queryArray['email'] = $request->otp;
        } else if ($phone) {
            $queryArray['phone'] = $request->otp;
        }

        $user = [];
        if (!blank($queryArray)) {
            $user = User::where($queryArray)->first();
        }

        if ($request->otp == '') {
            return response()->json([
                'status'  => 401,
                'message' => 'This otp field required.',
            ], 401);
        }

        if (blank($user)) {
            return response()->json([
                'status'  => 401,
                'message' => 'This user data not found',
            ], 401);
        }

        if ($user->status == UserStatus::INACTIVE) {
            return response()->json([
                'message' => 'Your account currently inactive. you can\'t login our system.',
                'status'  => 401,
            ], 401);
        }

        $validator->after(function ($validator) use ($user, $request, $email, $phone) {
            if (setting('otp_type_checking') == 'email' && !$email) {
                $validator->errors()->add('otp', 'Please provide valid email address.');
            } else if (setting('otp_type_checking') == 'phone' && !$phone) {
                $validator->errors()->add('otp', 'Please provide valid phone number.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $otp_digit_limit = setting('otp_digit_limit');
        $code            = rand(pow(10, $otp_digit_limit - 1), pow(10, $otp_digit_limit) - 1);
        $otp_expire_time = setting('otp_expire_time') ?? 5;
        $expire_date     = date("Y-m-d H:i:s", strtotime($otp_expire_time . ' minutes'));

        $date = new \DateTime;
        $date->modify("-$otp_expire_time minutes");
        $otp_expire_date = $date->format('Y-m-d H:i:s');
        $otp             = Otp::where(['user_id' => $user->id])->where('expire_date', '>=', $otp_expire_date)->latest('id')->first();

        if (!blank($otp)) {
            $otp->code        = $code;
            $otp->expire_date = $expire_date;
            $otp->save();

            $user->notify(new OneTimePasswordSend($otp->code));

            return response()->json([
                'status' => 200,
                'message'   => 'The Code re-generate successfully',
            ], 200);
        } else {
            $otpArray['user_id']     = $user->id;
            $otpArray['email']       = $user->email;
            $otpArray['phone']       = $user->phone;
            $otpArray['code']        = $code;
            $otpArray['expire_date'] = $expire_date;

            $otp = Otp::create($otpArray);

            $user->notify(new OneTimePasswordSend($otp->code));

            return response()->json([
                'status' => 200,
                'message'   => 'The Code generate successfully',
            ], 200);
        }
    }

    public function verifyOtp(Request $request)
    {
        $requestArray = [
            'code' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $requestArray);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $otp = Otp::where(['code' => $request->code])->latest('id')->first();
        if (blank($otp)) {
            return response()->json([
                'status' => 401,
                'message'   => 'The code is not valid.',
            ], 401);
        }

        $expire_date  = strtotime($otp->expire_date);
        $current_date = strtotime(date('Y-m-d H:i:s'));
        if ($expire_date >= $current_date) {

            $user = $otp->user;
            if ($user->status == UserStatus::INACTIVE) {
                auth('api')->logout();
                return response()->json([
                    'message' => 'Your account currently inactive. you can\'t login our system.',
                    'status'  => 401,
                ], 401);
            }

            if (!$token = Auth::guard('api')->login($user)) {
                return response()->json([
                    'data'    => [],
                    'message' => 'You try to using invalid username or password',
                    'status'  => 401,
                ], 401);
            }

            $role = $request->role;
            if ($role == UserRole::WAITER) {
                $restaurant = !blank($user->waiter->restaurant) ? new RestaurantResource($user->waiter->restaurant) : [];
                $waiter = $user->waiter->id;
            } else {
                $restaurant = !blank($user->restaurant) ? new RestaurantResource($user->restaurant) : [];
                $waiter = 0;
            }

            return (new PrivateUserResource($user))
                ->additional([
                    'token'      => $token,
                    'restaurant' => $restaurant,
                    'waiter'     => $waiter,
                ], 200);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'This code expire time is exceded',
            ], 401);
        }
    }
}
