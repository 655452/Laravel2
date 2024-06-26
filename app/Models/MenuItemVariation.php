<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemVariation extends Model
{
    public $timestamps  = false;
    protected $fillable = ['menu_item_id', 'restaurant_id', 'name', 'price'];
}
