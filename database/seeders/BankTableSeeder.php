<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankTableSeeder extends Seeder
{
    public array $banks = [
        [
            'user_id'        => "4",
            'bank_name'      => "Dutch Bangla Bank",
            'bank_code'      => "DBBLBDDH107",
            'recipient_name' => "Fabian C. Williams",
            'account_number' => "234867868345",
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->banks as $bank) {
                Bank::create([
                    'user_id'        => $bank['user_id'],
                    'bank_name'      => $bank['bank_name'],
                    'bank_code'      => $bank['bank_code'],
                    'recipient_name' => $bank['recipient_name'],
                    'account_number' => $bank['account_number'],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }
}
