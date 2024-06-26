<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_histories';
    protected $fillable = ['order_id', 'previous_status', 'current_status'];
    protected $casts = [
        'previous_status' => 'int',
        'current_status' => 'int',
        'order_id' => 'int',
    ];
}
