<?php
namespace Database\Seeders;

use App\Models\Ledger;
use Illuminate\Database\Seeder;

class LedgerTableSeeder extends Seeder
{
    public array $ledgers = [
        [
            'balance_id'   => 1,
            'type'         => 1,
            'amount'       => '28.50',
            'balance'      => '-28.50',
        ],
        [
            'balance_id'   => 7,
            'type'         => 5,
            'amount'       => '28.50',
            'balance'      => '28.50',
        ],
        [
            'balance_id'   => 1,
            'type'         => 5,
            'amount'       => '42.00',
            'balance'      => '14.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 1,
            'amount'       => '42.00',
            'balance'      => '-28.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 5,
            'amount'       => '42.00',
            'balance'      => '14.00',
        ],

        [
            'balance_id'   => 1,
            'type'         => 5,
            'amount'       => '102.00',
            'balance'      => '116.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 1,
            'amount'       => '85.50',
            'balance'      => '31.00',
        ],
        [
            'balance_id'   => 7,
            'type'         => 5,
            'amount'       => '85.50',
            'balance'      => '113.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 1,
            'amount'       => '12.00',
            'balance'      => '19.00',
        ],
        [
            'balance_id'   => 4,
            'type'         => 4,
            'amount'       => '12.00',
            'balance'      => '12.00',
        ],


        [
            'balance_id'   => 1,
            'type'         => 1,
            'amount'       => '9.50',
            'balance'      => '10.00',
        ],
        [
            'balance_id'   => 7,
            'type'         => 5,
            'amount'       => '9.50',
            'balance'      => '122.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 5,
            'amount'       => '22.00',
            'balance'      => '32.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 1,
            'amount'       => '22.00',
            'balance'      => '10.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 5,
            'amount'       => '22.00',
            'balance'      => '32.00',
        ],

        [
            'balance_id'   => 1,
            'type'         => 1,
            'amount'       => '38.00',
            'balance'      => '-6.00',
        ],
        [
            'balance_id'   => 7,
            'type'         => 5,
            'amount'       => '38.00',
            'balance'      => '160.00',
        ],
        [
            'balance_id'   => 2,
            'type'         => 5,
            'amount'       => '52.00',
            'balance'      => '52.00',
        ],
        [
            'balance_id'   => 2,
            'type'         => 1,
            'amount'       => '52.00',
            'balance'      => '0.00',
        ],
        [
            'balance_id'   => 2,
            'type'         => 5,
            'amount'       => '52.00',
            'balance'      => '46.00',
        ],


        [
            'balance_id'   => 2,
            'type'         => 5,
            'amount'       => '32.00',
            'balance'      => '32.00',
        ],
        [
            'balance_id'   => 2,
            'type'         => 1,
            'amount'       => '32.00',
            'balance'      => '00.00',
        ],
        [
            'balance_id'   => 1,
            'type'         => 5,
            'amount'       => '32.00',
            'balance'      => '78.00',
        ],
        [
            'balance_id'   => 2,
            'type'         => 5,
            'amount'       => '22.00',
            'balance'      => '22.00',
        ],
        [
            'balance_id'   => 2,
            'type'         => 1,
            'amount'       => '22.00',
            'balance'      => '00.00',
        ],

        [
            'balance_id'   => 1,
            'type'         => 5,
            'amount'       => '22.00',
            'balance'      => '100.00',
        ],

    ];

    public function run()
    {
        if (env('DEMO_MODE')) {
            foreach ($this->ledgers as $ledger) {
                Ledger::insert([
                    'balance_id'   => $ledger['balance_id'],
                    'type'         => $ledger['type'],
                    'amount'       => $ledger['amount'],
                    'balance'      => $ledger['balance'],
                    'creator_type' => 'App\Models\User',
                    'creator_id'   => '4',
                    'editor_type'  => 'App\Models\User',
                    'editor_id'    => '4',
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }
    }



}
