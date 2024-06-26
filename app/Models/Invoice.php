<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\Models\User;
use App\Traits\Uuids;

class Invoice extends BaseModel
{
    use Uuids;
    protected $primaryKey = 'id'; // or null
    protected $auditColumn       = true;

    protected $casts = ['meta' => 'array'];

    public function order()
    {
        return $this->hasOne(Order::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class)
            ->where('source_balance_id', auth()->user()->id)
            ->where('type', TransactionType::PAYMENT);
    }



}
