<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;

class CollectionTableSeeder extends Seeder
{
    public array $collections = [
        [
            'user_id'         => "4",
            'delivery_charge' => "800.00",
            'amount'          => "800.00",
        ],
        [
            'user_id'         => "4",
            'delivery_charge' => "50.00",
            'amount'          => "50.00",
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->collections as $collection) {
                Collection::create([
                    'user_id'         => $collection['user_id'],
                    'delivery_charge' => $collection['delivery_charge'],
                    'amount'          => $collection['amount'],
                    'date'            => now(),
                    'creator_type'    => "App\Models\User",
                    'creator_id'      => "1",
                    'editor_type'     => "App\Models\User",
                    'editor_id'       => "1",
                ]);
            }
        }
    }
}
