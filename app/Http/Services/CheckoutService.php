<?php

namespace App\Http\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\TransactionType;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Transaction;
use App\Models\User;

class CheckoutService
{
    public $owner_id = 1;
    public $comission;
    public $order_id;
    public $payment_method = PaymentMethod::CASH_ON_DELIVERY;

    public function __construct($order_id, $payment_method)
    {
        $this->comission      = setting('order_commission_percentage');
        $this->order_id       = $order_id;
        $this->payment_method = $payment_method;
    }

    public function payment()
    {
        $order = Order::where(['payment_status' => PaymentStatus::UNPAID])->find($this->order_id);
        if (!blank($order)) {
            return $this->generateTransaction($order);
        }
        return [
            'status'  => false,
            'message' => 'Your order not found or you already paid',
        ];
    }

    public function cancel()
    {
        $order = Order::where(['payment_status' => PaymentStatus::PAID])->where('status', OrderStatus::PENDING)->find($this->order_id);

        if (!blank($order)) {
            return $this->generateCancelTransaction($order);
        }
        return [
            'status'  => false,
            'message' => 'Your order not found or you already unpaid',
        ];
    }

    private function generateTransaction($order)
    {
        $invoice = Invoice::findOrFail($order->invoice_id);
        $user    = User::find($order->user_id);
        $restaurant    = Restaurant::find($order->restaurant_id);

        $restaurantowner_balance_id = !blank($restaurant) ? $restaurant->user->balance_id : 0;

        if (!$restaurantowner_balance_id) {
            return [
                'status'  => false,
                'message' => 'restaurant owner balance missing',
            ];
        }

        $meta = [
            'restaurant_id'        => $order->restaurant_id,
            'order_id'       => $order->id,
            'invoice_id'     => $order->invoice_id,
            'user_id'        => $user->id,
            'payment_method' => $this->payment_method,
        ];

        $this->addTransaction(TransactionType::ADDFUND, null, $user->balance_id, $invoice->meta['amount'], $meta);
        $this->addTransaction(TransactionType::TRANSFER, $user->balance_id, $this->owner_id, $invoice->meta['amount'], $meta);

        $order->payment_status = PaymentStatus::PAID;
        $order->payment_method = $meta['payment_method'];
        $order->paid_amount    = $invoice->meta['amount'];
        $order->save();

        return [
            'status'  => true,
            'message' => 'You paid order payment successfully',
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
            'payment_method' => $this->payment_method,
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

    public function generateInvoice($order)
    {
        $invoice_id = Str::uuid();

        $invoice               = new Invoice;
        $invoice->id           = $invoice_id;
        $invoice->meta         = ['order_id' => $order->id, 'amount' => $order->total, 'user_id' => $order->user_id];
        $invoice->creator_type = User::class;
        $invoice->editor_type  = User::class;
        $invoice->creator_id   = 1;
        $invoice->editor_id    = 1;
        $invoice->save();

        $order->invoice_id = $invoice_id;
        $order->save();
    }
}
