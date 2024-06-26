<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\SlugOptions;
use DB;

class Reservation extends BaseModel implements HasMedia
{
    use WatchableTrait, InteractsWithMedia;
    protected $table       = 'reservations';
    protected $auditColumn       = true;
    protected $guarded     = ['id'];
    protected $casts = [
        'status' => 'int',
    ];
    protected $fakeColumns = [];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function table()
    {
        return $this->belongsTo(Table::class)->with('restaurant');
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class,'time_slot_id');
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
