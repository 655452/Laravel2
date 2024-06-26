<?php

namespace App\Models;

use App\Models\BaseModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends BaseModel implements HasMedia
{

    use InteractsWithMedia;

    protected $table       = 'banners';
    protected $fillable    = ['title', 'short_description', 'link', 'sort', 'status'];
    protected $casts = [
        'status' => 'int',
    ];
    protected $auditColumn       = true;

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('banner'))) {
            return asset($this->getFirstMediaUrl('banner'));
        }
        return asset('assets/img/default/banner.jpg');
    }
    public function restuarant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }


}
