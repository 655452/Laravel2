<?php

namespace App\Http\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\TransactionType;
use App\Models\DeliveryBoyAccount;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Transaction;
use App\Models\User;

class PaymentTransactionService
{
    public $owner_id = 1;
    public $comission;
    public $order;

    public function __construct($order)
    {
        $this->comission = setting('order_commission_percentage');
        $this->order     = $order;
    }

    public function receive()
    {
        return $this->generateReceiveTransaction($this->order);
    }

    public function completed()
    {
        if (PaymentMethod::CASH_ON_DELIVERY == $this->order->payment_method) {
            return $this->generateCompletedTransaction($this->order);
        } else {
            $order = $this->order;
            $user  = User::find($order->delivery_boy_id);
            $meta  = [
                'restaurant_id'        => $order->restaurant_id,
                'order_id'       => $order->id,
                'invoice_id'     => $order->invoice_id,
                'user_id'        => $order->id,
                'payment_method' => $order->payment_method,
            ];

            $deliveryChargeAmount = $order->delivery_charge;

            $this->addTransaction(TransactionType::TRANSFER, $this->owner_id, $user->balance_id, $deliveryChargeAmount, $meta);
        }
    }

    public function rejected()
    {
        $order = Order::where(['payment_status' => PaymentStatus::PAID, 'status'=> OrderStatus::PENDING])->find($this->order->id);

        if (!blank($order) && ($order->payment_method != PaymentMethod::CASH_ON_DELIVERY)) {
            return $this->generateRejectedTransaction($order);
        }
        return [
            'status'  => false,
            'message' => 'Your order not found or you already unpaid',
        ];
    }

    public function canceled()
    {
        $order = Order::where(['payment_status' => PaymentStatus::PAID, 'status'=> OrderStatus::PENDING])->find($this->order->id);

        if (!blank($order) && ($order->payment_method != PaymentMethod::CASH_ON_DELIVERY)) {
            return $this->generateCancelTransaction($order);
        }
        return [
            'status'  => false,
            'message' => 'Your order not found or you already unpaid',
        ];
    }

    private function generateReceiveTransaction($order)
    {
        $invoice = Invoice::findOrFail($order->invoice_id);
        $user    = User::find($order->user_id);
        $restaurant    = Restaurant::find($order->restaurant_id);

        $restaurantowner_balance_id = !blank($restaurant) ? $restaurant->user->balance_id : 0;

        if (!$restaurantowner_balance_id) {
            return [
                'status'  => false,
                'message' => 'Restaurant owner balance missing',
            ];
        }

        $meta = [
            'restaurant_id'        => $order->restaurant_id,
            'order_id'       => $order->id,
            'invoice_id'     => $order->invoice_id,
            'user_id'        => $user->id,
            'payment_method' => $order->payment_method,
        ];

        $paymentAmount = ($invoice->meta['amount'] ?? 0) - $order->delivery_charge;
        $paymentAmount = $paymentAmount - (($this->comission / 100) * $paymentAmount);

        $this->addTransaction(TransactionType::TRANSFER, $this->owner_id, $restaurantowner_balance_id, $paymentAmount, $meta);

        $order->payment_status = PaymentStatus::PAID;
        $order->paid_amount    = $invoice->meta['amount'];
        $order->save();

        return [
            'status'  => true,
            'message' => 'The order payment paid successfully',
        ];
    }

    private function generateCompletedTransaction($order)
    {
        $invoice = Invoice::findOrFail($order->invoice_id);
        $user    = User::find($order->user_id);

        $meta = [
            'restaurant_id'        => $order->restaurant_id,
            'order_id'       => $order->id,
            'invoice_id'     => $order->invoice_id,
            'user_id'        => $user->id,
            'payment_method' => $order->payment_method,
        ];

        $paymentAmount = ($invoice->meta['amount'] ?? 0);

        $this->addTransaction(TransactionType::ADDFUND, null, $user->balance_id, $paymentAmount, $meta);
        $this->addTransaction(TransactionType::TRANSFER, $user->balance_id, $this->owner_id, $paymentAmount, $meta);

        $deliveryboyAccount = DeliveryBoyAccount::where('user_id', $order->delivery_boy_id)->first();
        if (!blank($deliveryboyAccount)) {
            $deliveryboyAccount->delivery_charge = $deliveryboyAccount->delivery_charge + $order->delivery_charge;
            $deliveryboyAccount->balance         = $deliveryboyAccount->balance + $order->total;
            $deliveryboyAccount->save();
        }

        $order->payment_status = PaymentStatus::PAID;
        $order->paid_amount    = $invoice->meta['amount'];
        $order->save();

        return [
            'status'  => true,
            'message' => 'The order payment paid successfully',
        ];
    }

    private function generateRejectedTransaction($order)
    {
        $invoice = Invoice::findOrFail($order->invoice_id);
        $user    = User::find($order->user_id);

        $meta = [
            'restaurant_id'        => $order->restaurant_id,
            'order_id'       => $order->id,
            'invoice_id'     => $order->invoice_id,
            'user_id'        => $user->id,
            'payment_method' => $this->order->payment_method,
        ];

        $this->addTransaction(TransactionType::REFUND, $this->owner_id, $user->balance_id, $invoice->meta['amount'], $meta);

        $order->payment_status = PaymentStatus::UNPAID;
        $order->payment_method = $meta['payment_method'];
        $order->paid_amount    = 0;
        $order->status         = OrderStatus::REJECT;
        $order->save();

        return [
            'status'  => true,
            'message' => 'You order payment cancel successfully',
        ];
    }

    private function generateCancelTransaction($order)
    {
        $invoice = Invoice::findOrFail($order->invoice_id);
        $user    = User::find($order->user_id);

        $meta = [
            'restaurant_id'        => $order->restaurant_id,
            'order_id'       => $order->id,
            'invoice_id'     => $order->invoice_id,
            'user_id'        => $user->id,
            'payment_method' => $this->order->payment_method,
        ];

        $this->addTransaction(TransactionType::REFUND, $this->owner_id, $user->balance_id, $invoice->meta['amount'], $meta);

        $order->payment_status = PaymentStatus::UNPAID;
        $order->payment_method = $meta['payment_method'];
        $order->paid_amount    = 0;
        $order->status         = OrderStatus::CANCEL;
        $order->save();

        return [
            'status'  => true,
            'message' => 'You order payment cancel successfully',
        ];
    }

    private function addTransaction($type, $source, $destination, $amount, $meta)
    {
        $transaction                         = new Transaction;
        $transaction->type                   = $type;
        $transaction->source_balance_id      = $source;
        $transaction->destination_balance_id = $destination;
        $transaction->amount                 = $amount;
        $transaction->status                 = 1;
        $transaction->meta                   = $meta;
        $transaction->invoice_id             = $meta['invoice_id'];
        $transaction->order_id               = $meta['order_id'];
        $transaction->restaurant_id                = $meta['restaurant_id'];
        $transaction->user_id                = $meta['user_id'];
        $transaction->creator_type           = User::class;
        $transaction->editor_type            = User::class;
        $transaction->creator_id             = 1;
        $transaction->editor_id              = 1;
        $transaction->save();
    }
}
