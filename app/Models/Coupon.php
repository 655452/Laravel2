<?php

namespace App\Models;


use App\Models\BaseModel;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Coupon extends BaseModel
{
    use HasSlug, WatchableTrait;

    protected $table       = 'coupons';
    protected $auditColumn = true;
    protected $fillable    = ['name', 'slug', 'discount_type', 'coupon_type', 'restaurant_id', 'user_limit', 'limit', 'amount', 'minimum_order_amount', 'from_date', 'to_date'];


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    public function getActionButtonAttribute()
    {
        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID > 1) {
            if (auth()->user()->restaurant_id != 0) {
                $this->restaurant_id == auth()->user()->restaurant_id;
                return 0;
            }
            return false;
        }
        return true;
    }



    public function creator()
    {
        return $this->morphTo();
    }


    public function restaurants()
    {
        return $this->belongsToMany(Branch::class);
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
