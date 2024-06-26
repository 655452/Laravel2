<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RequestWithdraw;

class RequestWithdrawSeeder extends Seeder
{
    public array $requestWithdraws = [
        [
            'user_id' => "4",
            'amount'  => "50.00",
            'status'  => "5",
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->requestWithdraws as $requestWithdraw) {
                RequestWithdraw::create([
                    'user_id'      => $requestWithdraw['user_id'],
                    'amount'       => $requestWithdraw['amount'],
                    'status'       => $requestWithdraw['status'],
                    'date'         => now(),
                    'creator_type' => "App\Models\User",
                    'creator_id'   => "1",
                    'editor_type'  => "App\Models\User",
                    'editor_id'    => "1",
                ]);
            }
        }
    }
}
