<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\v1\WithdrawResource;
use App\Models\Withdraw;
use App\Http\Controllers\BackendController;

class WithdrawController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $withdraws = Withdraw::where(['user_id' => auth()->user()->id])->get();
        return response()->json([
            'status' => 200,
            'data'   => WithdrawResource::collection($withdraws),
        ], 200);
    }
}
