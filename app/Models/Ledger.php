<?php

namespace App\Models;

use App\Enums\LedgerType;

class Ledger extends BaseModel
{
    protected $fillable = [
        'type',
        'amount',
        'balance_id',
        'balance',
    ];

    public function onModelCreated()
    {
        if($this->balance_id) {
            $balance = Balance::find($this->balance_id);
            $balance->balance = $this->balance;
            $balance->save();
        }
    }
}
