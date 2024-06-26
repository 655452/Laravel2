<?php

namespace App\Http\Services;

use App\Models\User;
use App\Notifications\NewShopOrderCreated;
use App\Notifications\OrderCreated;
use App\Notifications\OrderUpdated;
use App\Notifications\ReservationCreated;
use App\Notifications\ReservationUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PushNotificationService
{
    public function sendPushNotification($data, $topicName)
    {
        if (!empty($topicName)) {
            $topic = env('FCM_TOPIC') . '_' . str_replace(['@', '.', '+'], ['_', '_', ''], $topicName);
        } else {
            $topic = env('FCM_TOPIC');
        }

        $final = array(
            'to' => '/topics/' . $topic,
            'priority' => 'high',
            'notification' => [
                'body' => $data->description,
                'title' => $data->title,
                'sound' => 'Default',
                'image' => $data->image
            ],
        );
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . env('FCM_SECRET_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($final));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }


    public function fcmSubscribe($request)
    {

        $deviceToken = $request->device_token;
        $topic = env('FCM_TOPIC') . '_' . str_replace(['@', '.', '+'], ['_', '_', ''], $request->topic);


        $headers = array(
            'Authorization: key=' . env('FCM_SECRET_KEY'),
            'Content-Type: application/json'
        );
        $this->fcmGlobalSubscribe($request);
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://iid.googleapis.com/iid/v1/$deviceToken/rel/topics/$topic");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            return response()->json([
                'status' => 200,
                'message' => 'Subscribed',
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status'  => 401,
                'message' => $exception,
            ], 401);
        }
    }


    public function fcmGlobalSubscribe($request)
    {
        $deviceToken = $request->device_token;
        $topic = env('FCM_TOPIC');

        $headers = array(
            'Authorization: key=' . env('FCM_SECRET_KEY'),
            'Content-Type: application/json'
        );

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://iid.googleapis.com/iid/v1/$deviceToken/rel/topics/$topic");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            return response()->json([
                'status' => 200,
                'message' => 'Global Subscription',
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status'  => 401,
                'message' => $exception,
            ], 401);
        }
    }


    public function fcmUnsubscribe( $request)
    {
        $request->validate([
            'device_token' => 'required',
            'topic' => 'nullable',
        ]);

        $deviceToken = $request->token;

        $headers = array(
            'Authorization: key=' . env('FCM_SECRET_KEY'),
            'Content-Type: application/json'
        );

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://iid.googleapis.com/v1/web/iid/$deviceToken");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);

            return response()->json([
                'status' => 200,
                'message' => 'Unsubscribed',
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status'  => 401,
                'message' => $exception,
            ], 401);        }
    }

    public function sendWebNotification($order,$FcmToken)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $serverKey = env('FCM_SECRET_KEY');

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title"     => "New Order #" . $order->id,
                "body"      => 'A new order has been placed at ' . ucfirst($order->restaurant->name) . ' The order amount is ' . $order->total,
                'sound'     => 'default', // Optional
                'icon'      => public_path('images/fav.png'),
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        return true;
    }

    public  function sendNotificationReservation($reservation,$user,$type){
        try {

            $fcmTokens = User::where(['id' => $user->id])->whereNotNull('device_token')->pluck('device_token')->toArray();
            $FcmWabToken = User::where(['id' => $user->id])->whereNotNull('web_token')->pluck('web_token')->toArray();
            if (!blank($fcmTokens)) {
                if($type == 'store'){
                    $user->notify(new ReservationCreated($reservation, $fcmTokens));
                }else {
                    $user->notify(new ReservationUpdate($reservation, $fcmTokens));
                }
            }

            if (!blank($FcmWabToken)) {
                if($type == 'store'){
                    $user->notify(new ReservationCreated($reservation, $FcmWabToken));
                }else {
                    $user->notify(new ReservationUpdate($reservation, $FcmWabToken));
                }            }
        }catch (\Exception $exception){

        }
    }

    public  function sendNotificationOrder($order,$user,$type){
        try {

            $fcmTokens = User::where(['id' => $user->id])->whereNotNull('device_token')->pluck('device_token')->toArray();
            $FcmWabToken = User::where(['id' => $user->id])->whereNotNull('web_token')->pluck('web_token')->toArray();
            if (!blank($fcmTokens)) {
                if($type == 'customer'){
                    $user->notify(new OrderCreated($order, $fcmTokens));
                }else {
                    $user->notify(new NewShopOrderCreated($order, $fcmTokens));
                }
            }

            if (!blank($FcmWabToken)) {
                if($type == 'customer'){
                    $user->notify(new OrderCreated($order, $FcmWabToken));
                }else {
                    $user->notify(new NewShopOrderCreated($order, $FcmWabToken));
                }            }
        }catch (\Exception $exception){

        }
    }

    public  function sendNotificationOrderUpdate($order,$user,$type){
        try {

            $fcmTokens = User::where(['id' => $user->id])->whereNotNull('device_token')->pluck('device_token')->toArray();
            $FcmWabToken = User::where(['id' => $user->id])->whereNotNull('web_token')->pluck('web_token')->toArray();
            if (!blank($fcmTokens)) {
                if($type == 'customer'){
                    $user->notify(new OrderUpdated($order, $fcmTokens));
                }else if ($type == 'deliveryboy') {
                    $user->notify(new OrderUpdated($order, $fcmTokens));
                }
            }

            if (!blank($FcmWabToken)) {
                if($type == 'customer'){
                    $user->notify(new OrderUpdated($order, $FcmWabToken));
                }else if ($type == 'deliveryboy') {
                    $user->notify(new OrderUpdated($order, $FcmWabToken));
                }            }
        }catch (\Exception $exception){

        }
    }



}
