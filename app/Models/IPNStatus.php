<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPNStatus extends Model
{
    //
    protected $table = 'ipn_status';

    protected $fillable = [
        'payload',
        'status',
    ];
}
