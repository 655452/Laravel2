<?php

namespace App\Models;

use App\Models\User;
use Shipu\Watchable\Traits\WatchableTrait;

class Withdraw extends BaseModel
{
    use WatchableTrait;

    protected $table       = 'withdraws';
    protected $auditColumn       = true;
    protected $fillable    = ['date', 'user_id', 'amount'];

    protected $dates = [
        'date',
    ];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
