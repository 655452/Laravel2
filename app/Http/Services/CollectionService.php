<?php

namespace App\Http\Services;

use App\Enums\TransactionType;
use App\Models\Collection;
use App\Models\DeliveryBoyAccount;
use App\Models\Transaction;
use App\Models\User;

class CollectionService
{
    public $adminBalanceId = 1;

    public function createCollection( $userId, $collectionAmount, $collectionId = null )
    {
        $deliveryBoyAccount = DeliveryBoyAccount::where('user_id', $userId)->first();
        if ( !blank($deliveryBoyAccount) ) {
            $deliveryBoyCommissionAmount = number_format((($deliveryBoyAccount->delivery_charge * $collectionAmount) / $deliveryBoyAccount->balance), 2);
            if ( (int)$collectionId && $collectionId > 0 ) {
                $collection = Collection::find($collectionId);
                if ( !blank($collection) ) {
                    $collection->delivery_charge = $deliveryBoyCommissionAmount;
                    $collection->save();
                }
            }

            $user = User::find($userId);
            if ( !blank($user) ) {
                $transfer = app(TransactionService::class)->transfer($this->adminBalanceId, $user->balance_id, $deliveryBoyCommissionAmount);
                if ( $transfer->status ) {
                    $deliveryBoyAccount->delivery_charge = (int)$deliveryBoyAccount->delivery_charge - (int)$deliveryBoyCommissionAmount;
                    $deliveryBoyAccount->balance         = $deliveryBoyAccount->balance - $collectionAmount;
                    $deliveryBoyAccount->save();
                    ResponseService::set([
                        'status' => true,
                        'amount' => $deliveryBoyCommissionAmount
                    ]);
                } else {
                    ResponseService::set([
                        'status'  => false,
                        'message' => $transfer->message
                    ]);
                }
            } else {
                ResponseService::set([
                    'status'  => false,
                    'message' => 'The Balance id not found.',
                ]);
            }
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'The delivery boy account not found.',
            ]);
        }
        return ResponseService::response();
    }

    public function deleteCollection($userId, $collectionAmount, $deliveryBoyCommissionAmount)
    {
        $deliveryBoyAccount = DeliveryBoyAccount::where('user_id', $userId)->first();
        if ( !blank($deliveryBoyAccount) ) {
            $user = User::find($userId);
            if ( !blank($user) ) {
                $transfer = app(TransactionService::class)->transfer($user->balance_id, $this->adminBalanceId, $deliveryBoyCommissionAmount);
                if ( $transfer->status ) {
                    $deliveryBoyAccount->delivery_charge = $deliveryBoyAccount->delivery_charge + $deliveryBoyCommissionAmount;
                    $deliveryBoyAccount->balance         = $deliveryBoyAccount->balance + $collectionAmount;
                    $deliveryBoyAccount->save();
                    ResponseService::set([
                        'status' => true,
                        'amount' => $deliveryBoyCommissionAmount
                    ]);
                } else {
                    ResponseService::set([
                        'status'  => false,
                        'message' => $transfer->message
                    ]);
                }
            } else {
                ResponseService::set([
                    'status'  => false,
                    'message' => 'The Balance id not found.',
                ]);
            }
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'The delivery boy account not found.',
            ]);
        }
        return ResponseService::response();
    }
}
