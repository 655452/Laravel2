<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table    = 'otp';
    protected $fillable = ['user_id', 'email', 'phone', 'code', 'expire_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
