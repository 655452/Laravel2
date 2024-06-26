<?php

namespace App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Bank extends BaseModel
{
    protected $fillable    = ['user_id', 'bank_name', 'bank_code', 'recipient_name', 'account_number','mobile_agent_name','mobile_agent_number','paypal_id','upi_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
