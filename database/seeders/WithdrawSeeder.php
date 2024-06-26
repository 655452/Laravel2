<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdraw;

class WithdrawSeeder extends Seeder
{
    public array $withdraws = [
        [
            'user_id'             => "4",
            'payment_type'        => "5",
            'amount'              => "40.00",
            'request_withdraw_id' => "4",

        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->withdraws as $withdraw) {
                Withdraw::create([
                    'user_id'             => $withdraw['user_id'],
                    'payment_type'        => $withdraw['payment_type'],
                    'amount'              => $withdraw['amount'],
                    'date'                => now(),
                    'request_withdraw_id' => $withdraw['request_withdraw_id'],
                    'creator_type'        => "App\Models\User",
                    'creator_id'          => "1",
                    'editor_type'         => "App\Models\User",
                    'editor_id'           => "1",
                ]);
            }
        }
    }
}
