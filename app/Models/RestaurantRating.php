<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Models\Media;


class RestaurantRating extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $table       = 'restaurant_ratings';
    protected $auditColumn = true;
    protected $fillable    = ['user_id', 'restaurant_id', 'rating', 'review', 'status'];

    protected $casts = [
        'status'        => 'int',
        'rating'        => 'int',
        'restaurant_id' => 'int',
        'user_id'       => 'int',
    ];



    public function user()
    {
        return $this->belongsTo(User::class)->with('media');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }


    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('ratings'))) {
            return asset($this->getFirstMediaUrl('ratings'));
        }
        return null;
    }

}
