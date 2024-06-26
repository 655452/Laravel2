<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PushNotification;

class PushNotificationsSeeder extends Seeder
{
    public array $pushNotifications = [
        [
            'title'         => "Chicken Burger 10% Off",
            'description'   => "Our chicken burger is now available at a special discounted price, with 10% off for the next week!",
            'customer_id'   => null,
            'restaurant_id' => "1",
            'type'          => "10",
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->pushNotifications as $pushNotification) {
                PushNotification::create([
                    'title'         => $pushNotification['title'],
                    'description'   => $pushNotification['description'],
                    'customer_id'   => $pushNotification['customer_id'],
                    'restaurant_id' => $pushNotification['restaurant_id'],
                    'type'          => $pushNotification['type'],
                    'creator_type'  => "App\Models\User",
                    'creator_id'    => "1",
                    'editor_type'   => "App\Models\User",
                    'editor_id'     => "1",
                ]);
            }
        }
    }
}
