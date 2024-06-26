<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItemOption;

class MenuItemOptionsSeeder extends Seeder
{
    public array $menuItemOptions = [
        [
            "menu_item_id"  => 3,
            "restaurant_id" => 2,
            "name"          => "Soft Drink",
            "price"         => "0.60",
        ],
        [
            "menu_item_id"  => 3,
            "restaurant_id" => 2,
            "name"          => "Guacamole",
            "price"         => "0.50",
        ],
        [
            "menu_item_id"  => 3,
            "restaurant_id" => 2,
            "name"          => "Borhani",
            "price"         => "0.40",
        ],
        [
            "menu_item_id"  => 19,
            "restaurant_id" => 1,
            "name"          => "Coke Small 250ml",
            "price"         => "5.00",
        ],
        [
            "menu_item_id"  => 19,
            "restaurant_id" => 1,
            "name"          => "Coke Medium 500ml",
            "price"         => "9.00",
        ],
        [
            "menu_item_id"  => 19,
            "restaurant_id" => 1,
            "name"          => "Coke Large 1000ml",
            "price"         => "17.00",
        ],
        [
            "menu_item_id"  => 25,
            "restaurant_id" => 1,
            "name"          => "Coke 250ml",
            "price"         => "5.00",
        ],
        [
            "menu_item_id"  => 25,
            "restaurant_id" => 1,
            "name"          => "Pepsi",
            "price"         => "4.00",
        ],

        [
            "menu_item_id"  => 25,
            "restaurant_id" => 1,
            "name"          => "Souce",
            "price"         => "3.00",
        ],
        [
            "menu_item_id"  => 34,
            "restaurant_id" => 1,
            "name"          => "Drinks",
            "price"         => "5.00",
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->menuItemOptions as $menuItemOption) {
                MenuItemOption::create([
                    'menu_item_id'  => $menuItemOption['menu_item_id'],
                    'restaurant_id' => $menuItemOption['restaurant_id'],
                    'name'          => $menuItemOption['name'],
                    'price'         => $menuItemOption['price'],
                ]);
            }
        }
    }
}
