<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\QrCode;
use Spatie\Sluggable\HasSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\RatingsService;
use Illuminate\Support\Facades\Schema;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;
class Restaurant extends BaseModel implements HasMedia
{
    use WatchableTrait, InteractsWithMedia, HasSlug, SoftDeletes;
    protected $table       = 'restaurants';
    protected $guarded     = ['id'];
    protected $auditColumn     = true;
    protected $dates = ['deleted_at'];
    protected $fakeColumns = [];

    protected $casts = [
        'status' => 'int',
        'current_status' => 'int',
        'user_id' => 'int',
        'delivery_status' => 'int',
        'pickup_status' => 'int',
        'delivery_charge' => 'int',
        'table_status' => 'int',
        'applied' => 'int',
        'creator_id' => 'int',
        'editor_id ' => 'int',
    ];

    public function getRouteKeyName()
    {
        return request()->segment(1) === 'admin' ? 'id' : 'slug';
    }

    public function avgRating($restaurantID)
    {
        $rating = new RatingsService();
        return $rating->avgRating($restaurantID);
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class, 'restaurant_cuisines');
    }

    public function coupons()
    {
        if (Schema::hasColumn('coupons', 'slug')) {
            return $this->hasMany(Coupon::class);
        }
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with('media', 'roles');
    }


    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('restaurant'))) {
            $image = $this->getMedia('restaurant')->last();
            return $image->getUrl('image');
        }
        return asset('frontend/images/default/restaurant.png');
    }
    public function getLogoAttribute()
    {
        if (!empty($this->getFirstMediaUrl('restaurant_logo'))) {
            return asset($this->getFirstMediaUrl('restaurant_logo'));
        }
        return asset('frontend/images/default/logo.png');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('image')->performOnCollections('restaurant')->keepOriginalImageFormat();
    }

    public function getavgRatingsAttribute()
    {
        $rating      = new RatingsService();
        $ratingArray = $rating->avgRating($this->id);
        if (!blank($ratingArray)) {
            return $ratingArray;
        }
        return null;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeRestaurantowner($query)
    {
        if (Auth::check() && auth()->user()->myrole != 1) {
            $query->where('user_id', auth()->id());
        }
    }

    public function OnModelCreated()
    {
        $qrCode                = new QrCode();
        $qrCode->restaurant_id = $this->id;
        $qrCode->creator_type  = $this->creator_type;
        $qrCode->creator_id    = $this->creator_id;
        $qrCode->editor_type   = $this->editor_type;
        $qrCode->editor_id     = $this->editor_id;
        $qrCode->save();
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(RestaurantRating::class);
    }
    public function deleteMedia($restaurant, $mediaName, $mediaId)
    {
        $media = Media::where([
            'file_name' => $mediaName,
            'collection_name' => 'restaurant',
            'model_id' => $mediaId,
            'model_type' => Restaurant::class,
        ])->first();

        if ($media) {
            $media->delete();
        }
    }
}
