<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryStatusHistories;
class DeliveryStatusHistoriesSeeder extends Seeder
{
    public array $deliveryStatusOptions = [
        [
            "order_id" => 4,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 7,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 8,
            "user_id" => 3,
            "status" => 10,
        ],
        [
            "order_id" => 8,
            "user_id" => 6,
            "status" => 5,
        ],
        [
            "order_id" => 13,
            "user_id" => 6,
            "status" => 5,
        ],
        [
            "order_id" => 14,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 23,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 3,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 18,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 28,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 29,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 19,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 22,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 20,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 21,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 43,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 42,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 37,
            "user_id" => 3,
            "status" => 5,
        ],
        [
            "order_id" => 46,
            "user_id" => 3,
            "status" => 5,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->deliveryStatusOptions as $deliveryStatusOption) {
                DeliveryStatusHistories::create([
                    'order_id' => $deliveryStatusOption['order_id'],
                    'user_id'  => $deliveryStatusOption['user_id'],
                    'status'   => $deliveryStatusOption['status'],
                ]);
            }
        }
    }
}
