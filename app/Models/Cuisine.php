<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\CategoryStatus;
use Spatie\Sluggable\HasSlug;
use App\Enums\CategoryRequested;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Cuisine extends BaseModel implements HasMedia
{
    use HasSlug, WatchableTrait, InteractsWithMedia;

    protected $table       = 'cuisines';
    protected $auditColumn       = true;
    protected $fillable    = ['name', 'slug', 'description', 'status', 'requested'];
    protected $casts = [
        'status' => 'int',
        'requested' => 'int',
    ];

    public function getSlugOptions(): SlugOptions
    {

        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('cuisines'))) {
             $image = $this->getMedia('cuisines')->last();
            return $image->getUrl('image');
        }
        return asset('frontend/images/default/cuisine.png');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('image')->performOnCollections('cuisines')->keepOriginalImageFormat()->sharpen(10);
    }


    public function creator()
    {
        return $this->morphTo();
    }

    public function OnModelCreating()
    {
        $roleID          = auth()->user()->myrole ?? 0;
        $this->requested = CategoryRequested::NON_REQUESTED;
        if ($roleID > 1) {
            $this->requested = CategoryRequested::REQUESTED;
            $this->status    = CategoryStatus::INACTIVE;
        }
    }

    public function deleteMedia($mediaName, $mediaId)
    {
        $media = Media::where([
            'collection_name' => $mediaName,
            'model_id' => $mediaId,
            'model_type' => Cuisine::class,
        ])->first();

        if ($media) {
            $media->delete();
        }
    }

    public function OnModelSaving()
    {
        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID == 1) {
            $this->status = request('status');
        }
    }


    public function getActionButtonAttribute()
    {
        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID > 1) {
            if (($this->creator_id == auth()->id()) && ($this->status == CategoryStatus::INACTIVE)) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function scopeOwner($query)
    {
        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID > 1) {
            $query->where('creator_id', auth()->id());
            $query->where('status', CategoryStatus::INACTIVE);
        }
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_cuisines');
    }
}
