<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 5/3/20
 * Time: 11:25 AM
 */

namespace App\Http\Services;

use App\Enums\PaymentMethod;
use App\Models\UserDeposit;

class DepositService
{
    public $adminBalanceId = 1;

    public function depositAdjust( $userId, $depositAmount, $orderLimitAmount )
    {
        $status              = false;
        $globalDepositAmount = 0;
        $deposit             = UserDeposit::where('user_id', $userId)->first();
        if ( !blank($deposit) ) {
            if ( $depositAmount > 0 ) {
                if ( $deposit->deposit_amount > $depositAmount ) {
                    $cashBackAmount      = $deposit->deposit_amount - $depositAmount;
                    $globalDepositAmount = $cashBackAmount;
                    $cashBack            = app(TransactionService::class)->cashBack($this->adminBalanceId, $deposit->user->balance_id, $cashBackAmount, false);
                    if ( $cashBack->status ) {
                        $status = true;
                        ResponseService::set([
                            'status' => true,
                            'amount' => $depositAmount
                        ]);
                    } else {
                        ResponseService::set([
                            'status'  => false,
                            'message' => $cashBack->message
                        ]);
                    }
                } elseif ( $deposit->deposit_amount < $depositAmount ) {
                    $extraDepositAmount       = $depositAmount - $deposit->deposit_amount;
                    $globalDepositAmount = $extraDepositAmount;

                    if($depositAmount > $deposit->user->balance->balance) {
                        $extraAddFund = $extraDepositAmount - $deposit->user->balance->balance;
                        $addFund             = app(TransactionService::class)->addFund(0, $deposit->user->balance_id, PaymentMethod::CASH, $extraAddFund);
                    } else {
                        $addFund = (object) ['status' => true];
                    }

                    if ( $addFund->status ) {
                        $deposit = app(TransactionService::class)->deposit($deposit->user->balance_id, $this->adminBalanceId, $extraDepositAmount);
                        if ( $deposit->status ) {
                            $status = true;
                            ResponseService::set([
                                'status' => true,
                                'amount' => $depositAmount
                            ]);
                        } else {
                            ResponseService::set([
                                'status'  => false,
                                'message' => $deposit->message
                            ]);
                        }
                    } else {
                        ResponseService::set([
                            'status'  => false,
                            'message' => $addFund->message
                        ]);
                    }
                } else {
                    ResponseService::set([
                        'status' => true,
                        'amount' => $depositAmount
                    ]);
                }
            } else {
                ResponseService::set([
                    'status' => true,
                    'amount' => $depositAmount
                ]);
            }

            if ( $globalDepositAmount > 0 || $orderLimitAmount > 0 ) {
                $userDeposit = UserDeposit::where([ 'user_id' => $userId ])->first();
                if ( !blank($userDeposit) ) {
                    if ( $status ) {
                        $userDeposit->deposit_amount = $depositAmount;
                    }
                    $userDeposit->limit_amount = $orderLimitAmount;
                    $userDeposit->save();

                    if(ResponseService::response()->status == false && ResponseService::response()->message == 'something wrong') {
                        ResponseService::set([
                            'status' => true,
                            'amount' => $depositAmount
                        ]);
                    }
                }
            }
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'The user not found',
            ]);
        }

        return ResponseService::response();
    }

}
