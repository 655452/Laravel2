<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Balance;

class BalancesSeeder extends Seeder
{
    public array $balancesOptions = [
        [
            "name"         => "admin",
            "type"         => 1,
            "balance"      => "2381.88",
            "creator_type" => "1",
            "creator_id"   => 1,
            "editor_type"  => "1",
            "editor_id"    => 1,
        ],
        [
            "name"         => "customer",
            "type"         => 1,
            "balance"      => "110.00",
            "creator_type" => "1",
            "creator_id"   => 1,
            "editor_type"  => "1",
            "editor_id"    => 1,
        ],
        [
            "name"         => "restaurantowner",
            "type"         => 1,
            "balance"      => "126.00",
            "creator_type" => "1",
            "creator_id"   => 1,
            "editor_type"  => "1",
            "editor_id"    => 1,
        ],
        [
            "name"         => "deliveryboy",
            "type"         => 1,
            "balance"      => "900.00",
            "creator_type" => "1",
            "creator_id"   => 1,
            "editor_type"  => "1",
            "editor_id"    => 1,
        ],
        [
            "name"         => "waiter",
            "type"         => 1,
            "balance"      => "15.50",
            "creator_type" => "1",
            "creator_id"   => 1,
            "editor_type"  => "1",
            "editor_id"    => 1,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->balancesOptions as $balancesOption) {
                Balance::create([
                    'name'         => $balancesOption['name'],
                    'type'         => $balancesOption['type'],
                    'balance'      => $balancesOption['balance'],
                    'creator_type' => $balancesOption['creator_type'],
                    'creator_id'   => $balancesOption['creator_id'],
                    'editor_type'  => $balancesOption['editor_type'],
                    'editor_id'    => $balancesOption['editor_id'],
                ]);
            }
        }
    }
}
