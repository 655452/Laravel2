<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebNotificationController extends Controller{
    public function store(Request $request){
        try {
            $user = User::find(auth()->user()->id);
            $user->web_token = $request->token;
            $user->save();
            return response()->json(['Token successfully stored.']);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
