<?php

namespace Database\Seeders;

use App\Models\Waiter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WaiterTableSeeder extends Seeder{
    public array $waiters = [
        [
            "restaurant_id" => 1,
            "user_id"       => 5,
        ],
        [
            "restaurant_id" => 2,
            "user_id"       => 15,
        ],
        [
            "restaurant_id" => 3,
            "user_id"       => 16,
        ],
        [
            "restaurant_id" => 4,
            "user_id"       => 17,
        ],
        [
            "restaurant_id" => 5,
            "user_id"       => 18,
        ],
        [
            "restaurant_id" => 6,
            "user_id"       => 19,
        ],
        [
            "restaurant_id" => 7,
            "user_id"       => 20,
        ],
        [
            "restaurant_id" => 8,
            "user_id"       => 21,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){ 
        if (env('DEMO_MODE') && File::exists(app_path('Models/Waiter.php')) ) {
            foreach ($this->waiters as $waiter) {
                Waiter::create([
                    'restaurant_id' => $waiter['restaurant_id'],
                    'user_id'       => $waiter['user_id'],
                ]);
            }
        }
    }
}
