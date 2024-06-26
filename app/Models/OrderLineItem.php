<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLineItem extends Model
{
    protected $table    = 'order_line_items';
    protected $fillable = ['restaurant_id', 'order_id', 'product_id', 'quantity', 'unit_price', 'discounted_price', 'item_total', 'menu_item_variation_id', 'options','instructions', 'options_total'];
    protected $casts = [
        'restaurant_id' => 'int',
        'product_id' => 'int',
        'order_id' => 'int',
        'quantity' => 'int',
        'menu_item_variation_id' => 'int',
        'menu_item_id' => 'int',
        'options_total' => 'int',
    ];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function variation()
    {
        return $this->belongsTo(MenuItemVariation::class, 'menu_item_variation_id');
    }
}
