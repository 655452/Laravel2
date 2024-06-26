<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Spatie\Sluggable\HasSlug;
use App\Models\MenuItemOption;
use App\Models\MenuItemVariation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MenuItem extends BaseModel implements HasMedia
{
    use HasSlug, WatchableTrait, InteractsWithMedia;

    protected $table       = 'menu_items';
    protected $auditColumn       = true;
    protected $guarded     = ['id'];
    protected $casts = [
        'status' => 'int',
        'counter' => 'int',
        'restaurant_id' => 'int',
        'order' => 'int',
        'creator_id' => 'int',
        'editor_id ' => 'int',
    ];
    protected $fakeColumns = [];

    public function getRouteKeyName()
    {
        return request()->segment(1) === 'admin' ? 'id' : 'slug';
    }


    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_menu_items');
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'menu_items');
    }

    public function orders()
    {
        return $this->hasMany(OrderLineItem::class);
    }

    public function scopeIsLive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @param $query
     * @param Category $category
     * @return mixed
     */
    public function scopeFromCategory($query, Category $category)
    {
        return $query->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('menu-items'))) {
            $image = $this->getMedia('menu-items')->last();
            return $image->getUrl('image');
        }
        return asset('frontend/images/default/menuitem.png');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('image')->performOnCollections('menu-items')->keepOriginalImageFormat();
    }

    public function getImagesAttribute()
    {
        $retArray  = [];
        $menuItems = $this->getMedia('menu-items');
        if (!blank($menuItems)) {
            foreach ($menuItems as $key => $menuItem) {
                $retArray[$key] = asset($menuItem->getUrl());
            }
        }

        return $retArray;

    }

    public function MenuItemWithVariation($restaurant_id, $variation_id = 0)
    {
        return $this->variations()->where(['restaurant_id' => $restaurant_id, 'id' => $variation_id])->first();
    }



    public function productOrderSum($restaurant_id, $variation_id = 0, $total = false)
    {
        if ($total) {
            return $this->orders()->where(['restaurant_id' => $restaurant_id])->whereHas('order', function ($query) use ($restaurant_id) {
                $query->where(['restaurant_id' => $restaurant_id]);
                $query->where('status', '!=', OrderStatus::CANCEL);
                $query->where('status', '!=', OrderStatus::REJECT);
            })->sum('quantity');
        } else {
            return $this->orders()->where(['restaurant_id' => $restaurant_id, 'menu_item_variation_id' => $variation_id])->whereHas('order', function ($query) use ($restaurant_id) {
                $query->where(['restaurant_id' => $restaurant_id]);
                $query->where('status', '!=', OrderStatus::CANCEL);
                $query->where('status', '!=', OrderStatus::REJECT);
            })->sum('quantity');
        }
    }


    public function deleteMedia($mediaName, $mediaId)
    {
        $media = Media::where([
            'collection_name' => $mediaName,
            'model_id' => $mediaId,
            'model_type' => MenuItem::class,
        ])->first();

        if ($media) {
            $media->delete();
        }
    }


    public function scopeOwner($query)
    {
        if(auth()->user()->restaurant){
            $query->where('restaurant_id', auth()->user()->restaurant->id);
        }
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function cuisine()
    {
        return $this->belongsTo(cuisine::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variations()
    {
        return $this->hasMany(MenuItemVariation::class);
    }

    public function options()
    {
        return $this->hasMany(MenuItemOption::class);
    }



}
