<?php

namespace App\Models;

use Shipu\Watchable\Traits\WatchableTrait;

class TimeSlot extends BaseModel
{
    use WatchableTrait;

    protected $table       = 'time_slots';
    protected $auditColumn       = true;
    protected $fillable    = ['start_time', 'end_time', 'restaurant_id', 'status'];
    protected $casts = [
        'status' => 'int',
    ];

    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class,'time_slot_id');
    }

}
