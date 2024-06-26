<?php

namespace Database\Seeders;

use App\Models\OrderHistory;
use Illuminate\Database\Seeder;

class OrderHistoryTableSeeder extends Seeder
{
    public array $orderHistories = [
        [
            'order_id'        => 1,
            'previous_status' => null,
            'current_status'  => 5,
        ],
        [
            'order_id'        => 1,
            'previous_status' => 5,
            'current_status'  => 14,
        ],
        [
            'order_id'        => 1,
            'previous_status' => 14,
            'current_status'  => 15,
        ],
        [
            'order_id'        => 1,
            'previous_status' => 15,
            'current_status'  => 17,
        ],
        [
            'order_id'        => 1,
            'previous_status' => 17,
            'current_status'  => 20,
        ],


        [
            'order_id'        => 2,
            'previous_status' => null,
            'current_status'  => 5,
        ],
        [
            'order_id'        => 2,
            'previous_status' => 5,
            'current_status'  => 14,
        ],
        [
            'order_id'        => 2,
            'previous_status' => 14,
            'current_status'  => 15,
        ],
        [
            'order_id'        => 2,
            'previous_status' => 15,
            'current_status'  => 17,
        ],
        [
            'order_id'        => 2,
            'previous_status' => 17,
            'current_status'  => 20,
        ],


        [
            'order_id'        => 3,
            'previous_status' => NULL,
            'current_status'  => 5,
        ],
        [
            'order_id'        => 4,
            'previous_status' => NULL,
            'current_status'  => 5,
        ],
        [
            'order_id'        => 3,
            'previous_status' => 5,
            'current_status'  => 12,
        ],
        [
            'order_id'        => 4,
            'previous_status' => 5,
            'current_status'  => 14,
        ],
        [
            'order_id'        => 4,
            'previous_status' => 14,
            'current_status'  => 15,
        ],


        [
            'order_id'        => 4,
            'previous_status' => 15,
            'current_status'  => 17,
        ],
        [
            'order_id'        => 4,
            'previous_status' => 17,
            'current_status'  => 20,
        ],
        [
            'order_id'        => 5,
            'previous_status' => NULL,
            'current_status'  => 5,
        ],
        [
            'order_id'        => 6,
            'previous_status' => NULL,
            'current_status'  => 5,
        ],
        [
            'order_id'        => 6,
            'previous_status' => 5,
            'current_status'  => 14,
        ],


        [
            'order_id'        => 6,
            'previous_status' => 14,
            'current_status'  => 15,
        ],
        [
            'order_id'        => 6,
            'previous_status' => 15,
            'current_status'  => 17,
        ],
        [
            'order_id'        => 6,
            'previous_status' => 17,
            'current_status'  => 20,
        ],
        [
            'order_id'        => 7,
            'previous_status' => NULL,
            'current_status'  => 5,
        ],
        [
            'order_id'        => 7,
            'previous_status' => 5,
            'current_status'  => 14,
        ],

        
        [
            'order_id'        => 8,
            'previous_status' => NULL,
            'current_status'  => 5,
        ],
    ];

    public function run()
    {
        if (env('DEMO_MODE')) {
            foreach ($this->orderHistories as $orderHistory) {
                OrderHistory::insert([
                    'order_id'        => $orderHistory['order_id'],
                    'previous_status' => $orderHistory['previous_status'],
                    'current_status'  => $orderHistory['current_status'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
