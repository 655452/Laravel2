<?php

namespace Database\Seeders;

use App\Models\DineInOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DineinOrdersTableSeeder extends Seeder{
    public array $dineInOrders = [
        [
            "order_id"      => 58,
            "restaurant_id" => 1,
            "waiter_id"     => 1,
            "table_id"      => 1,
            "payment_type"  => 25,
        ],

        [
            "order_id"      => 59,
            "restaurant_id" => 1,
            "waiter_id"     => 1,
            "table_id"      => 2,
            "payment_type"  => 25,
        ],
        [
            "order_id"      => 60,
            "restaurant_id" => 1,
            "waiter_id"     => 1,
            "table_id"      => 3,
            "payment_type"  => 25,
        ],
        [
            "order_id"      => 61,
            "restaurant_id" => 2,
            "waiter_id"     => 1,
            "table_id"      => 4,
            "payment_type"  => 25,
        ],
        [
            "order_id"      => 62,
            "restaurant_id" => 2,
            "waiter_id"     => 1,
            "table_id"      => 4,
            "payment_type"  => 25,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE') && File::exists(app_path('Models/DineInOrder.php')) ) {
            foreach ($this->dineInOrders as $dineInOrder) {
                DineInOrder::create([
                    'order_id'      => $dineInOrder['order_id'],
                    'restaurant_id' => $dineInOrder['restaurant_id'],
                    'waiter_id'     => $dineInOrder['waiter_id'],
                    'table_id'      => $dineInOrder['table_id'],
                    'payment_type'  => $dineInOrder['payment_type'],
                ]);
            }
        }
    }
}

