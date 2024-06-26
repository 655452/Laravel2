<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\RequestWithdrawStatus;
use App\Http\Controllers\BackendController;
use App\Http\Requests\Api\RequestWithdrawRequest;
use App\Http\Resources\v1\RequestWithdrawResource;
use App\Models\RequestWithdraw;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Validator;


class RequestWithdrawController extends BackendController
{
    use ApiResponse;


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
        $requestWithdraws = RequestWithdraw::where(['user_id' => auth()->user()->id])->latest()->get();
        $requestedAmount = RequestWithdraw::where(['user_id' => auth()->user()->id])->latest()->sum('amount');
        $withdrawAmount = Withdraw::where(['user_id' => auth()->user()->id])->latest()->sum('amount');
        $orderBalance = auth()->user()->myrole == 4?auth()->user()->deliveryBoyAccount->balance:0;
        return response()->json([
            'status' => 200,
            'data'   =>['requestWithdraws'=>RequestWithdrawResource::collection($requestWithdraws),'balance' =>['totalBalance'=>auth()->user()->balance->balance,'orderBalance'=>$orderBalance,'requestedAmount'=>$requestedAmount,'withdrawAmount'=>$withdrawAmount]],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request )
    {

        $rules     = new RequestWithdrawRequest;
        $validator = Validator::make($request->all(), $rules->rules());

        $validator->after(function ($validator) use ($rules) {
            $rules->checkBalanceAmount(0, $validator);
        });


        if (!$validator->fails()) {
            $requestWithdraw          = new RequestWithdraw;
            $requestWithdraw->user_id = auth()->id();
            $requestWithdraw->amount  = $request->amount;
            $requestWithdraw->status  = RequestWithdrawStatus::PENDING;
            $requestWithdraw->date    = $request->date;
            $requestWithdraw->save();
            return response()->json([
                'status'  => 200,
                'message' => 'You request withdraw completed successfully.',
            ], 200);
        }else {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id )
    {
        $rules     = new RequestWithdrawRequest;
        $validator = Validator::make($request->all(), $rules->rules());

        $validator->after(function ($validator) use ($rules, $id) {
            $rules->checkBalanceAmount($id, $validator);
        });

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }
        $requestWithdraw = RequestWithdraw::where('status', RequestWithdrawStatus::PENDING)->findOrFail($id);

        if (!blank($requestWithdraw)) {
            $requestWithdraw->user_id = auth()->id();
            $requestWithdraw->amount  = $request->amount;
            $requestWithdraw->date    = $request->date;
            $requestWithdraw->save();
            return response()->json([
                'status'  => 200,
                'message' => 'You request withdraw update successfully.',
            ], 200);
        }else {
            return response()->json([
                'status'  => 422,
                'message' => 'You can not update this data.',
            ], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id )
    {
        $requestWithdraw = RequestWithdraw::where('status', RequestWithdrawStatus::PENDING)->findOrFail($id);
        if ( !blank($requestWithdraw) ) {
            $requestWithdraw->delete();
            return response()->json([
                'status'  => 200,
                'message' => 'You request withdraw delete successfully.',
            ], 200);

        } else {
            return response()->json([
                'status'  => 422,
                'message' => 'You can not delete this data.',
            ], 422);        }
    }

}
