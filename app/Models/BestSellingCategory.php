<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestSellingCategory extends Model
{
    protected $table    = 'best_selling_category';
    protected $fillable = ['category_id', 'restaurant_id', 'counter'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
