<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\TransactionType;
use App\Http\Controllers\BackendController;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentController extends BackendController
{
    public $owner_id  = 1;
    public $comission = 20;
    public $order_id  = 2;

    public function index()
    {
        $order_id = $this->order_id;
        $order    = Order::where(['payment_status' => PaymentStatus::UNPAID])->findOrFail($order_id);
        if (!blank($order)) {
            $this->generateLedger($order);
            echo "Successfully Paid";
        } else {
            echo "Already Paid";
        }
    }

    public function cancel()
    {
        $order_id = $this->order_id;
        $order    = Order::where(['payment_status' => PaymentStatus::PAID])->where('status', '!=', OrderStatus::CANCEL)->findOrFail($order_id);

        if (!blank($order)) {
            $this->generateCancelLedger($order);
            echo "Successfully Cancel";
        } else {
            echo "Already Cancel";
        }
    }

    public function generateCancelLedger($order)
    {
        $invoice = Invoice::findOrFail($order->invoice_id);
        $user    = User::find($order->user_id);

        $shopowner_balance_id = $order->items->first()->shop->user->balance_id;

        $payment_method = PaymentMethod::CASH_ON_DELIVERY;
        $meta           = [
            'shop_id'        => $order->shop_id,
            'order_id'       => $order->id,
            'invoice_id'     => $order->invoice_id,
            'user_id'        => $user->id,
            'payment_method' => $payment_method,
        ];

        $amount = $invoice->meta['amount'] ? ($invoice->meta['amount'] - (($this->comission / 100) * $invoice->meta['amount'])) : 0;

        $this->addTransaction(TransactionType::LIFTING, $shopowner_balance_id, $this->owner_id, $amount, $meta);
        $this->addTransaction(TransactionType::LIFTING, $this->owner_id, $user->balance_id, $invoice->meta['amount'], $meta);

        $order->payment_status = PaymentStatus::UNPAID;
        $order->payment_method = $meta['payment_method'];
        $order->paid_amount    = 0;
        $order->status         = OrderStatus::CANCEL;
        $order->save();
    }

    public function generateLedger($order)
    {
        $invoice = Invoice::findOrFail($order->invoice_id);
        $user    = User::find($order->user_id);

        $shopowner_balance_id = $order->items->first()->shop->user->balance_id;

        $payment_method = PaymentMethod::CASH_ON_DELIVERY;
        $meta           = [
            'shop_id'        => $order->shop_id,
            'order_id'       => $order->id,
            'invoice_id'     => $order->invoice_id,
            'user_id'        => $user->id,
            'payment_method' => $payment_method,
        ];

        $this->addTransaction(TransactionType::ADDFUND, null, $user->balance_id, $invoice->meta['amount'], $meta);
        $this->addTransaction(TransactionType::PAYMENT, $user->balance_id, $this->owner_id, $invoice->meta['amount'], $meta);

        $amount = $invoice->meta['amount'] ? ($invoice->meta['amount'] - (($this->comission / 100) * $invoice->meta['amount'])) : 0;

        $this->addTransaction(TransactionType::PAYMENT, $this->owner_id, $shopowner_balance_id, $amount, $meta);

        $order->payment_status = PaymentStatus::PAID;
        $order->payment_method = $meta['payment_method'];
        $order->paid_amount    = $invoice->meta['amount'];
        $order->save();
    }

    private function addTransaction($type, $source, $destination, $amount, $meta)
    {
        $transaction                         = new Transaction;
        $transaction->type                   = $type;
        $transaction->source_balance_id      = $source;
        $transaction->destination_balance_id = $destination;
        $transaction->amount                 = $amount;
        $transaction->status                 = 1;
        $transaction->invoice_id             = $meta['invoice_id'];
        $transaction->order_id               = $meta['order_id'];
        $transaction->shop_id                = $meta['shop_id'];
        $transaction->user_id                = $meta['user_id'];
        $transaction->meta                   = $meta;
        $transaction->save();
    }

    public function invoice()
    {
        $order_id = $this->order_id;
        $order    = Order::find($order_id);

        $this->generateInvoice($order);
    }

    private function generateInvoice($order)
    {
        $invoice_id = Str::uuid();

        $invoice       = new Invoice;
        $invoice->id   = $invoice_id;
        $invoice->meta = ['order_id' => $order->id, 'amount' => $order->total, 'user_id' => $order->user_id];
        $invoice->save();

        $order->invoice_id = $invoice_id;
        $order->save();

        echo "Success";
    }

}
