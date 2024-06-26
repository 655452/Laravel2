<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\BaseModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Report extends BaseModel implements HasMedia
{

    use InteractsWithMedia;

    protected $table       = 'reports';
    protected $fillable    = ['order_id', 'description'];

    protected $auditColumn       = true;

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('report'))) {
            return asset($this->getFirstMediaUrl('report'));
        }
        return asset('assets/img/default/banner.jpg');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'creator_id');
    }


}
