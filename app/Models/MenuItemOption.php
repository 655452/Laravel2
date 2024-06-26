<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemOption extends Model
{
	public $timestamps = false;
    protected $fillable = ['shop_product_id', 'product_id', 'restaurant_id', 'name', 'price'];
}
