<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Addon extends Model implements HasMedia
{

    use InteractsWithMedia;

    protected $table       = 'addons';
    protected $fillable    = ['title', 'slug', 'description','version','date','author','files','purchase_username', 'purchase_code','status'];

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('addon'))) {
            return asset($this->getFirstMediaUrl('addon'));
        }
        return asset('assets/images/logo.png');
    }

}
