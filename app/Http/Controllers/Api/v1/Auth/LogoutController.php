<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function action()
    {
        auth('api')->logout();
        return response()->json([ 'status' => 200, 'message' => 'Successfully logged out' ], 200);
    }

}
