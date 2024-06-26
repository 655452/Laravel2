<?php

namespace App\Models;

use App\Models\Restaurant;
use Shipu\Watchable\Traits\WatchableTrait;

class Table extends BaseModel
{
    use WatchableTrait;

    protected $table       = 'tables';
    protected $auditColumn       = true;
    protected $fillable    = ['name', 'capacity', 'restaurant_id', 'status'];
    protected $casts = [
        'status' => 'int',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

}
