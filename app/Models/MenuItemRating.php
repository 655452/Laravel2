<?php
namespace App\Models;
use App\Models\BaseModel;
use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Models\Media;

class MenuItemRating extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'menu_item_ratings';
    protected $auditColumn = true;
    protected $fillable = ['user_id', 'menu_item_id', 'rating', 'review', 'status'];

    protected $casts = [
        'status' => 'int',
        'rating' => 'int',
        'menu_item_id' => 'int',
        'user_id' => 'int',
    ];

    

    
    public function user()
    {
        return $this->belongsTo(User::class)->with('media');
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('ratings'))) {
            return asset($this->getFirstMediaUrl('ratings'));
        }
        return null;
    }
}
