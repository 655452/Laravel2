<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $table    = 'payment_settings';
    public $timestamps  = false;
    protected $fillable = ['key', 'value', 'gateway_id', 'user_id'];
}
