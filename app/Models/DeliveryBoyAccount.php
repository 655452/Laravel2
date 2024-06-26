<?php

namespace App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoyAccount extends Model
{
    protected $table = 'delivery_boy_accounts';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
