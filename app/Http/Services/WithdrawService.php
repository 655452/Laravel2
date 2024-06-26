<?php

namespace App\Http\Services;

use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;

class WithdrawService
{
    public $owner_id = 1;
    public $amount;
    public $user_id;
    public $invoice_id;
    public $payment_method = PaymentMethod::CASH_ON_DELIVERY;

    public function __construct($user_id, $amount)
    {
        $this->user_id = $user_id;
        $this->amount  = $amount;
    }

    public function withdraw()
    {
        $this->invoice_id = $this->generateInvoice();
        return $this->generateTransaction($this->user_id, $this->amount, $this->invoice_id);
    }

    public function withdrawCancel()
    {
        return $this->generateCancelTransaction($this->user_id, $this->amount);
    }

    private function generateTransaction($user_id, $amount, $invoice_id)
    {
        $user    = User::find($user_id);
        $invoice = Invoice::findOrFail($invoice_id);

        $meta = [
            'restaurant_id'        => 0,
            'order_id'       => 0,
            'invoice_id'     => $invoice->id,
            'user_id'        => $user->id,
            'payment_method' => $this->payment_method,
        ];

        $this->addTransaction(TransactionType::WITHDRAW, $user->balance_id, $this->owner_id, $amount, $meta);
        $this->addTransaction(TransactionType::WITHDRAW, $this->owner_id, 0, $amount, $meta);

        return [
            'status'  => true,
            'message' => 'Withdraw successfully',
        ];
    }

    private function generateCancelTransaction($user_id, $amount)
    {
        $user = User::find($user_id);

        $meta = [
            'restaurant_id'        => 0,
            'order_id'       => 0,
            'invoice_id'     => 0,
            'user_id'        => $user->id,
            'payment_method' => $this->payment_method,
        ];

        $this->addTransaction(TransactionType::ADDFUND, null, $this->owner_id, $amount, $meta);
        $this->addTransaction(TransactionType::CASHBACK, $this->owner_id, $user->balance_id, $amount, $meta);

        return [
            'status'  => true,
            'message' => 'Withdraw Cancel successfully',
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

    public function generateInvoice()
    {
        $invoice_id = Str::uuid();

        $invoice               = new Invoice;
        $invoice->id           = $invoice_id;
        $invoice->meta         = ['order_id' => 0, 'amount' => $this->amount, 'user_id' => $this->user_id];
        $invoice->creator_type = User::class;
        $invoice->editor_type  = User::class;
        $invoice->creator_id   = 1;
        $invoice->editor_id    = 1;
        $invoice->save();
        return $invoice->id;
    }
}
