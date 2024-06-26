<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends BaseModel
{
    use HasSlug;

    protected $table       = 'pages';
    protected $auditColumn       = true;
    protected $fillable    = ['title', 'slug', 'description', 'footer_menu_section_id'];

    public function getRouteKeyName()
    {
        return request()->segment(1) === 'admin' ? 'id' : 'slug';
    }

    
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function footer_menu_section()
    {
        return $this->belongsTo(FooterMenuSection::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
