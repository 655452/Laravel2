<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryBoyAccount;


class DeliveryBoyAccountsSeeder extends Seeder
{
    public array $deliveryBoyAccountsOptions = [
        [
            "user_id"         => 4,
            "delivery_charge" => "900.00",
            "balance"         => "900.00",
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->deliveryBoyAccountsOptions as $deliveryBoyAccountsOption) {
                DeliveryBoyAccount::create([
                    'user_id'         => $deliveryBoyAccountsOption['user_id'],
                    'delivery_charge' => $deliveryBoyAccountsOption['delivery_charge'],
                    'balance'         => $deliveryBoyAccountsOption['balance'],
                ]);
            }
        }
    }
}
