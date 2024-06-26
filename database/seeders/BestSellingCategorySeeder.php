<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BestSellingCategory;

class BestSellingCategorySeeder extends Seeder
{
    public array $bestSellingCategories = [
        [
            'category_id'   => "20",
            'restaurant_id' => "1",
            'counter'       => "11",
        ],
        [
            'category_id'   => "8",
            'restaurant_id' => "1",
            'counter'       => "4",
        ],
        [
            'category_id'   => "36",
            'restaurant_id' => "3",
            'counter'       => "4",
        ],
        [
            'category_id'   => "34",
            'restaurant_id' => "3",
            'counter'       => "1",
        ],
        [
            'category_id'   => "20",
            'restaurant_id' => "4",
            'counter'       => "3",
        ],
        [
            'category_id'   => "30",
            'restaurant_id' => "4",
            'counter'       => "2",
        ],
        [
            'category_id'   => "11",
            'restaurant_id' => "5",
            'counter'       => "2",
        ],
        [
            'category_id'   => "6",
            'restaurant_id' => "5",
            'counter'       => "1",
        ],
        [
            'category_id'   => "23",
            'restaurant_id' => "27",
            'counter'       => "1",
        ],

        [
            'category_id'   => "13",
            'restaurant_id' => "7",
            'counter'       => "1",
        ],
        [
            'category_id'   => "12",
            'restaurant_id' => "7",
            'counter'       => "1",
        ],
        [
            'category_id'   => "12",
            'restaurant_id' => "6",
            'counter'       => "3",
        ],
        [
            'category_id'   => "6",
            'restaurant_id' => "6",
            'counter'       => "1",
        ],
        [
            'category_id'   => "23",
            'restaurant_id' => "2",
            'counter'       => "4",
        ]
    ];

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->bestSellingCategories as $bestSellingCategory) {
                BestSellingCategory::create([
                    'category_id'   => $bestSellingCategory['category_id'],
                    'restaurant_id' => $bestSellingCategory['restaurant_id'],
                    'counter'       => $bestSellingCategory['counter'],
                ]);
            }
        }
    }
}
