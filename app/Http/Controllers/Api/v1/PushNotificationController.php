<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\PushNotificationService;
use Illuminate\Support\Facades\Validator;

class PushNotificationController extends Controller
{
    protected $pushNotificationService;
    public function __construct(PushNotificationService $pushNotificationService )
    {
        $this->pushNotificationService = $pushNotificationService;
    }
    
    public function fcmSubscribe(Request $request)
    {
        $validation = Validator::make($request->all(),  [
            'device_token' => 'required',
            'topic' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validation->errors(),
            ], 422);
        }

        return $this->pushNotificationService->fcmSubscribe($request);
        
    }
 
    public function fcmUnsubscribe(Request $request)
    {
        return $this->pushNotificationService->fcmUnsubscribe($request);
    }

}
