<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $table    = 'gateways';
    public $timestamps  = false;
    protected $fillable = ['name', 'status', 'user_id'];
    protected $casts = [
        'status' => 'int',
    ];
}
