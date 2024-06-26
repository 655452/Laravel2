<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantCuisine;
class RestaurantCuisinesTableSeeder extends Seeder{
    public array $restaurantCuisines = [
        [
            "restaurant_id" => 1,
            "cuisine_id"    => 1,
        ],
        [
            "restaurant_id" => 1,
            "cuisine_id"    => 8,
        ],
        [
            "restaurant_id" => 2,
            "cuisine_id"    => 3,
        ],
        [
            "restaurant_id" => 2,
            "cuisine_id"    => 5,
        ],
        [
            "restaurant_id" => 2,
            "cuisine_id"    => 7,
        ],
        [
            "restaurant_id" => 2,
            "cuisine_id"    => 8,
        ],
        [
            "restaurant_id" => 4,
            "cuisine_id"    => 1,
        ],
        [
            "restaurant_id" => 4,
            "cuisine_id"    => 2,
        ],
        [
            "restaurant_id" => 4,
            "cuisine_id"    => 4,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 1,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 2,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 3,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 4,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 5,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 6,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 7,
        ],
        [
            "restaurant_id" => 5,
            "cuisine_id"    => 8,
        ],
        [
            "restaurant_id" => 6,
            "cuisine_id"    => 2,
        ],
        [
            "restaurant_id" => 6,
            "cuisine_id"    => 4,
        ],
        [
            "restaurant_id" => 7,
            "cuisine_id"    => 7,
        ],
        [
            "restaurant_id" => 7,
            "cuisine_id"    => 8,
        ],
        [
            "restaurant_id" => 8,
            "cuisine_id"    => 3,
        ],
        [
            "restaurant_id" => 8,
            "cuisine_id"    => 7,
        ],  
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->restaurantCuisines as $restaurantCuisine) {
                RestaurantCuisine::create([
                    'restaurant_id' => $restaurantCuisine['restaurant_id'],
                    'cuisine_id'    => $restaurantCuisine['cuisine_id'],
                ]);
            }
        }
    }
}
