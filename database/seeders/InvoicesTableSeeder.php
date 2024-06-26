<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;


class InvoicesTableSeeder extends Seeder
{
    public array $invoices = [

        [
            'id'           => "aa361d9c-f98f-420c-88bf-0557e191e54f",
            'meta'         => '{"order_id":1,"amount":42,"user_id":1}',
        ],
        [
            'id'           => "33399cb5-9f10-45e7-8f61-904e7eab5195", //
            'meta'         => '{"order_id":5,"amount":102,"user_id":1}',
        ],
        [
            'id'           => "4d317537-6c12-4787-8687-482e52fba78b",
            'meta'         => '{"order_id":8,"amount":22,"user_id":2}',
        ],
        [
            'id'           => "66522b3f-f473-41c4-ab98-5f304f085754",
            'meta'         => '{"order_id":2,"amount":102,"user_id":1}',
        ],
        [
            'id'           => "9e15a20a-db17-4782-adfe-4d84ba5c68d7",
            'meta'         => '{"order_id":3,"amount":42,"user_id":1}',
        ],


        [
            'id'           => "0b044a53-433b-4f36-a0b6-870474ad03f7",
            'meta'         => '{"order_id":1,"amount":42,"user_id":1}',
        ],
        [
            'id'           => "c389492f-b21c-43e7-a16a-a3a37ce86ec9",
            'meta'         => '{"order_id":7,"amount":32,"user_id":2}',
        ],
        [
            'id'           => "f42148dc-6842-4f2d-8e79-4038c5f8d4fa",
            'meta'         => '{"order_id":6,"amount":52,"user_id":2}',
        ],



    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->invoices as $invoice) {
                Invoice::create([
                    'id'           => $invoice['id'],
                    'meta'         => $invoice['meta'],
                    'remarks'      => null,
                    'creator_type' => "App\Models\User",
                    'creator_id'   => 1,
                    'editor_type'  => "App\Models\User",
                    'editor_id'    => 1,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }
    }
}
