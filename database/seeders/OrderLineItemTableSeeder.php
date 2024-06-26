<?php
namespace Database\Seeders;

use App\Models\OrderLineItem;
use Illuminate\Database\Seeder;

class OrderLineItemTableSeeder extends Seeder
{
    public array $orderLineItems = [
        [
            'order_id'               => 1,
            'restaurant_id'          => 1,
            'menu_item_id'           => 19,
            'quantity'               => 1,
            'unit_price'             => 30.00,
            'discounted_price'       => 00.00,
            'item_total'             => 30.00,
            'menu_item_variation_id' => 4,
            'options'                => '[]',
            'options_total'          => 0,
        ],
        [
            'order_id'               => 2,
            'restaurant_id'          => 1,
            'menu_item_id'           => 50,
            'quantity'               => 1,
            'unit_price'             => 90.00,
            'discounted_price'       => 00.00,
            'item_total'             => 90.00,
            'menu_item_variation_id' => 0,
            'options'                => '[]',
            'options_total'          => 0,
        ],
        [
            'order_id'               => 3,
            'restaurant_id'          => 1,
            'menu_item_id'           => 48,
            'quantity'               => 1,
            'unit_price'             => 30.00,
            'discounted_price'       => 00.00,
            'item_total'             => 30.00,
            'menu_item_variation_id' => 0,
            'options'                => '[]',
            'options_total'          => 0,
        ],
        [
            'order_id'               => 4,
            'restaurant_id'          => 1,
            'menu_item_id'           => 32,
            'quantity'               => 1,
            'unit_price'             => 10.00,
            'discounted_price'       => 30.00,
            'item_total'             => 10.00,
            'menu_item_variation_id' => 0,
            'options'                => '[]',
            'options_total'          => 0,
        ],
        [
            'order_id'               => 5,
            'restaurant_id'          => 1,
            'menu_item_id'           => 50,
            'quantity'               => 1,
            'unit_price'             => 90.00,
            'discounted_price'       => 00.00,
            'item_total'             => 90.00,
            'menu_item_variation_id' => 0,
            'options'                => '[]',
            'options_total'          => 0,
        ],

        
        [
            'order_id'               => 6,
            'restaurant_id'          => 1,
            'menu_item_id'           => 19,
            'quantity'               => 1,
            'unit_price'             => 30.00,
            'discounted_price'       => 00.00,
            'item_total'             => 30.00,
            'menu_item_variation_id' => 4,
            'options'                => '[]',
            'options_total'          => 0,
        ],
        [
            'order_id'               => 6,
            'restaurant_id'          => 1,
            'menu_item_id'           => 32,
            'quantity'               => 1,
            'unit_price'             => 10.00,
            'discounted_price'       => 30.00,
            'item_total'             => 10.00,
            'menu_item_variation_id' => 4,
            'options'                => '[]',
            'options_total'          => 0,
        ],
        [
            'order_id'               => 7,
            'restaurant_id'          => 1,
            'menu_item_id'           => 54,
            'quantity'               => 1,
            'unit_price'             => 20.00,
            'discounted_price'       => 00.00,
            'item_total'             => 20.00,
            'menu_item_variation_id' => 0,
            'options'                => '[]',
            'options_total'          => 0,
        ],
        [
            'order_id'               => 8,
            'restaurant_id'          => 1,
            'menu_item_id'           => 53,
            'quantity'               => 1,
            'unit_price'             => 10.00,
            'discounted_price'       => 75.00,
            'item_total'             => 10.00,
            'menu_item_variation_id' => 0,
            'options'                => '[]',
            'options_total'          => 0,
        ],


    ];

    public function run()
    {
        if (env('DEMO_MODE')) {
            foreach ($this->orderLineItems as $orderLineItem) {
                OrderLineItem::insert([
                    'order_id'               => $orderLineItem['order_id'],
                    'restaurant_id'          => $orderLineItem['restaurant_id'],
                    'menu_item_id'           => $orderLineItem['menu_item_id'],
                    'quantity'               => $orderLineItem['quantity'],
                    'unit_price'             => $orderLineItem['unit_price'],
                    'discounted_price'       => $orderLineItem['discounted_price'],
                    'item_total'             => $orderLineItem['item_total'],
                    'menu_item_variation_id' => $orderLineItem['menu_item_variation_id'],
                    'options'                => $orderLineItem['options'],
                    'options_total'          => $orderLineItem['options_total'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
