<?php

namespace App\Models;

use App\Enums\LedgerType;
use App\Enums\TransactionType;
use App\Models\User;
use Shipu\Watchable\Traits\HasModelEvents;

class Transaction extends BaseModel
{
    use HasModelEvents;

    protected $fillable = [
        'type',
        'source_balance_id',
        'destination_balance_id',
        'amount',
        'status',
        'meta',
        'invoice_id',
        'order_id',
        'restaurant_id',
        'user_id'
    ];


    protected $casts = [
        'meta' => 'array',
        'status' => 'int',
        'type' => 'int',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function destinationUser()
    {
        return $this->belongsTo(User::class, 'destination_balance_id', 'balance_id');
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_balance_id', 'balance_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'meta->restaurant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'meta->user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'meta->order_id');
    }

    public function onModelCreated()
    {
        if ($this->type == TransactionType::ADDFUND) {  // done
            $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();

            $led               = new Ledger();
            $led->type         = LedgerType::CR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->destination_balance_id;
            $led->balance      = !blank($ledger) ? (int)$ledger->balance + (int)$this->amount : $this->amount;
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();
        } elseif ($this->type == TransactionType::PAYMENT) {  //done
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();

            $led               = new Ledger();
            $led->type         = LedgerType::DR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->source_balance_id;
            $led->balance      = !blank($ledger) ? (int)$ledger->balance - (int)$this->amount : $this->amount;
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();

            $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();

            $led               = new Ledger();
            $led->type         = LedgerType::CR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->destination_balance_id;
            $led->balance      = !blank($ledger) ? (int)$ledger->balance + (int)$this->amount : $this->amount;
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();
        } elseif ($this->type == TransactionType::REFUND) { //done
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();

            if (!blank($ledger)) {
                $led               = new Ledger();
                $led->type         = LedgerType::DR;
                $led->amount       = $this->amount;
                $led->balance_id   = $this->source_balance_id;
                $led->balance      = !blank($ledger) ? (int)$ledger->balance - (int)$this->amount : $this->amount;
                $led->creator_type = User::class;
                $led->editor_type  = User::class;
                $led->creator_id   = auth()->user()->id;
                $led->editor_id    = auth()->user()->id;
                $led->save();
            }

            $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();

            if (!blank($ledger)) {
                $led               = new Ledger();
                $led->type         = LedgerType::CR;
                $led->amount       = $this->amount;
                $led->balance_id   = $this->destination_balance_id;
                $led->balance      = !blank($ledger) ? (int)$ledger->balance + (int)$this->amount : $this->amount;
                $led->creator_type = User::class;
                $led->editor_type  = User::class;
                $led->creator_id   = auth()->user()->id;
                $led->editor_id    = auth()->user()->id;
                $led->save();
            }
        } elseif ($this->type == TransactionType::TRANSFER) { //done
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();
            $led               = new Ledger();
            $led->type         = LedgerType::DR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->source_balance_id;
            $led->balance      = !blank($ledger) ? (int)$ledger->balance - (int)$this->amount : (0 - $this->amount); // latest code
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();
            $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();
            $led               = new Ledger();
            $led->type         = LedgerType::CR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->destination_balance_id;
            $led->balance      = !blank($ledger) ? (int)$ledger->balance + (int)$this->amount : $this->amount;
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();
        } elseif ($this->type == TransactionType::CASHBACK) {
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();

            if (!blank($ledger)) {
                $led               = new Ledger();
                $led->type         = LedgerType::DR;
                $led->amount       = $this->amount;
                $led->balance_id   = $this->source_balance_id;
                $led->balance      = !blank($ledger) ? (int)$ledger->balance - (int)$this->amount : $this->amount;
                $led->creator_type = User::class;
                $led->editor_type  = User::class;
                $led->creator_id   = auth()->user()->id;
                $led->editor_id    = auth()->user()->id;
                $led->save();
            }

            $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();

            if (!blank($ledger)) {
                $led               = new Ledger();
                $led->type         = LedgerType::CR;
                $led->amount       = $this->amount;
                $led->balance_id   = $this->destination_balance_id;
                $led->balance      = !blank($ledger) ? (int)$ledger->balance + (int)$this->amount : $this->amount;
                $led->creator_type = User::class;
                $led->editor_type  = User::class;
                $led->creator_id   = auth()->user()->id;
                $led->editor_id    = auth()->user()->id;
                $led->save();
            }
        } elseif ($this->type == TransactionType::WITHDRAW) { //done
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();

            if ($this->source_balance_id != 0) {
                $led = new Ledger();
                $led->type = LedgerType::DR;
                $led->amount = $this->amount;
                $led->balance_id = $this->source_balance_id;
                $led->balance = !blank($ledger) ? (int)$ledger->balance - (int)$this->amount : $this->amount;
                $led->creator_type = User::class;
                $led->editor_type = User::class;
                $led->creator_id = auth()->user()->id;
                $led->editor_id = auth()->user()->id;
                $led->save();
            }

            if ($this->destination_balance_id != 0) {
                $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();
                $led               = new Ledger();
                $led->type         = LedgerType::CR;
                $led->amount       = $this->amount;
                $led->balance_id   = $this->destination_balance_id;
                $led->balance      = !blank($ledger) ? (int)$ledger->balance + (int)$this->amount : $this->amount;
                $led->creator_type = User::class;
                $led->editor_type  = User::class;
                $led->creator_id   = auth()->user()->id;
                $led->editor_id    = auth()->user()->id;
                $led->save();
            }
        } elseif ($this->type == TransactionType::DEPOSIT) { //done
            $ledger = Ledger::where(['balance_id' => $this->source_balance_id])->orderBy('id', 'desc')->first();

            $led               = new Ledger();
            $led->type         = LedgerType::DR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->source_balance_id;
            $led->balance      = !blank($ledger) ? (int)$ledger->balance - (int)$this->amount : (0 - $this->amount); // latest code
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();

            $ledger = Ledger::where(['balance_id' => $this->destination_balance_id])->orderBy('id', 'desc')->first();

            $led               = new Ledger();
            $led->type         = LedgerType::CR;
            $led->amount       = $this->amount;
            $led->balance_id   = $this->destination_balance_id;
            $led->balance      = !blank($ledger) ? (int)$ledger->balance + (int)$this->amount : $this->amount;
            $led->creator_type = User::class;
            $led->editor_type  = User::class;
            $led->creator_id   = auth()->user()->id;
            $led->editor_id    = auth()->user()->id;
            $led->save();
        }
    }

    public function scopeUsermeta($query, $id)
    {
        return $query->where(['meta->user_id' => $id]);
    }
}
