<?php

namespace App\Models;

use App\Models\User;
use Shipu\Watchable\Traits\WatchableTrait;

class Collection extends BaseModel
{
    use WatchableTrait;

    protected $table       = 'collection';
    protected $auditColumn       = true;

    protected $dates = [
        'date',
    ];

    protected $fillable    = ['user_id', 'delivery_charge', 'amount','date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCollectionOwner($query)
    {
        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID == 4) {
            $query->where('user_id', auth()->id());
        }
    }

}
