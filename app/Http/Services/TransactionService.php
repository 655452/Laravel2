<?php

namespace App\Http\Services;

use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;

class TransactionService
{

    protected function transaction( $type = 0,  $sourceBalanceId = 0,  $destinationBalanceId = 0,  $paymentMethod = 0, $amount = 0, $orderId = 0 )
    {
        $transaction = [
            'type'                   => $type,
            'source_balance_id'      => $sourceBalanceId,
            'destination_balance_id' => $destinationBalanceId,
            'amount'                 => $amount,
            'status'                 => 1,
            'creator_type'           => User::class,
            'editor_type'            => User::class,
            'creator_id'             => auth()->user()->id,
            'editor_id'              => auth()->user()->id,
            'meta'                   => [],
            'invoice_id'             => 0,
            'order_id'               => 0,
            'restaurant_id'                => 0,
            'user_id'                => 0,
        ];

        if ( $orderId > 0 && is_int($orderId) ) {
            $order = Order::find($orderId);
            if ( !blank($order) ) {
                $meta                      = [
                    'payment_method' => $paymentMethod == 0 ? PaymentMethod::WALLET : $paymentMethod,
                    'invoice_id'     => $order->invoice_id,
                    'order_id'       => $orderId,
                    'restaurant_id'        => (int)$order->restaurant_id,
                    'user_id'        => $order->user_id
                ];
                $transaction['meta']       = $meta;
                $transaction['invoice_id'] = $order->invoice_id;
                $transaction['order_id']   = $orderId;
                $transaction['restaurant_id']    = $order->restaurant_id;
                $transaction['user_id']    = $order->user_id;
            } else {
                $meta                = [
                    'payment_method' => $paymentMethod == 0 ? PaymentMethod::WALLET : $paymentMethod,
                ];
                $transaction['meta'] = $meta;
            }
        } else {
            $meta                = [
                'payment_method' => $paymentMethod == 0 ? PaymentMethod::WALLET : $paymentMethod,
            ];
            $transaction['meta'] = $meta;
        }

        $transaction = Transaction::create($transaction);
        if ( !blank($transaction) ) {
            ResponseService::set([
                'status'   => true,
                'order_id' => $orderId,
                'amount'   => $amount
            ]);
        } else {
            ResponseService::set([
                'status'  => false,
                'message' => 'something wrong'
            ]);
        }
        return ResponseService::response();
    }

    public function addFund(  $sourceBalanceId = 0,  $destinationBalanceId = 0,  $paymentMethod = 0, $amount = 0, $orderId = 0 ) //done
    {
        return $this->transaction(TransactionType::ADDFUND, $sourceBalanceId, $destinationBalanceId, $paymentMethod, $amount, $orderId);
    }

    public function payment(  $sourceBalanceId = 0,  $destinationBalanceId = 0, $amount = 0, $orderId = 0 ) //done
    {
        return $this->transaction(TransactionType::PAYMENT, $sourceBalanceId, $destinationBalanceId, 0, $amount, $orderId);
    }

    public function refund(  $sourceBalanceId = 0,  $destinationBalanceId = 0, $amount = 0, $orderId = 0 )
    {
        return $this->transaction(TransactionType::REFUND, $sourceBalanceId, $destinationBalanceId, 0, $amount, $orderId);
    }

    public function transfer(  $sourceBalanceId = 0,  $destinationBalanceId = 0, $amount = 0, $orderId = 0 ) //done
    {
        return $this->transaction(TransactionType::TRANSFER, $sourceBalanceId, $destinationBalanceId, 0, $amount, $orderId);
    }

    public function withdraw( $sourceBalanceId = 0,  $destinationBalanceId = 0, $amount = 0) //done
    {
        $transfer = $this->transaction(TransactionType::WITHDRAW, $sourceBalanceId, $destinationBalanceId, PaymentMethod::WALLET, $amount, 0);
        if($transfer->status) {
            return $this->transaction(TransactionType::WITHDRAW, $destinationBalanceId, 0, PaymentMethod::WALLET, $amount, 0);
        }
        return $transfer;
    }

    public function cashBack(  $sourceBalanceId = 0,  $destinationBalanceId = 0, $amount = 0, $addFund = true) //done
    {
        if($addFund) {
            $addFund = $this->addFund( 0, $sourceBalanceId, PaymentMethod::WALLET, $amount, 0 );
            if($addFund->status) {
                return $this->transaction(TransactionType::CASHBACK, $sourceBalanceId, $destinationBalanceId, PaymentMethod::WALLET, $amount, 0);
            }
            return $addFund;
        } else {
            return $this->transaction(TransactionType::CASHBACK, $sourceBalanceId, $destinationBalanceId, PaymentMethod::WALLET, $amount, 0);
        }

    }

    public function deposit(  $sourceBalanceId = 0,  $destinationBalanceId = 0, $amount = 0) //done
    {
        return $this->transaction(TransactionType::DEPOSIT, $sourceBalanceId, $destinationBalanceId, PaymentMethod::CASH, $amount, 0);
    }
}

