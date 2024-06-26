<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsTablesSeeder extends Seeder
{
    public array $transactions = [

        [
            "type"                   => '15',
            "source_balance_id"      => '1',
            "destination_balance_id" => '7',
            "amount"                 => '28.50',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"aa361d9c-f98f-420c-88bf-0557e191e54f","order_id":1,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "aa361d9c-f98f-420c-88bf-0557e191e54f",
            "order_id"               => "1",
            "restaurant_id"          => "1",
            "user_id"                => "1",
            'created_at'             => '2024-04-29 10:04:24',
            'updated_at'             => '2024-04-29 10:04:24',
        ],
        [
            "type"                   => '1',
            "source_balance_id"      => '0',
            "destination_balance_id" => '1',
            "amount"                 => '42.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":5,"invoice_id":"aa361d9c-f98f-420c-88bf-0557e191e54f","order_id":1,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "aa361d9c-f98f-420c-88bf-0557e191e54f",
            "order_id"               => "1",
            "restaurant_id"          => "1",
            "user_id"                => "1",
            'created_at'             => '2024-04-29 10:04:36',
            'updated_at'             => '2024-04-29 10:04:36',
        ],
        [
            "type"                   => '5',
            "source_balance_id"      => '1',
            "destination_balance_id" => '1',
            "amount"                 => '42.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"aa361d9c-f98f-420c-88bf-0557e191e54f","order_id":1,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "aa361d9c-f98f-420c-88bf-0557e191e54f",
            "order_id"               => "1",
            "restaurant_id"          => "1",
            "user_id"                => "1",
        ],
        [
            "type"                   => '1',
            "source_balance_id"      => '0',
            "destination_balance_id" => '1',
            "amount"                 => '102.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":"15","invoice_id":"66522b3f-f473-41c4-ab98-5f304f085754","order_id":2,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "66522b3f-f473-41c4-ab98-5f304f085754",
            "order_id"               => "2",
            "restaurant_id"          => "1",
            "user_id"                => "1",
        ],
        [
            "type"                   => '15',
            "source_balance_id"      => '1',
            "destination_balance_id" => '7',
            "amount"                 => '85.50',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"66522b3f-f473-41c4-ab98-5f304f085754","order_id":2,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "66522b3f-f473-41c4-ab98-5f304f085754",
            "order_id"               => "2",
            "restaurant_id"          => "1",
            "user_id"                => "1",
        ],


        [
            "type"                   => '15',
            "source_balance_id"      => '1',
            "destination_balance_id" => '4',
            "amount"                 => '12.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"66522b3f-f473-41c4-ab98-5f304f085754","order_id":2,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "66522b3f-f473-41c4-ab98-5f304f085754",
            "order_id"               => "2",
            "restaurant_id"          => "1",
            "user_id"                => "1",
        ],
        [
            "type"                   => '15',
            "source_balance_id"      => '1',
            "destination_balance_id" => '7',
            "amount"                 => '9.50',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"0b044a53-433b-4f36-a0b6-870474ad03f7","order_id":4,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "0b044a53-433b-4f36-a0b6-870474ad03f7",
            "order_id"               => "4",
            "restaurant_id"          => "1",
            "user_id"                => "1",
        ],
        [
            "type"                   => '1',
            "source_balance_id"      => '0',
            "destination_balance_id" => '1',
            "amount"                 => '22.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":5,"invoice_id":"0b044a53-433b-4f36-a0b6-870474ad03f7","order_id":4,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "0b044a53-433b-4f36-a0b6-870474ad03f7",
            "order_id"               => "4",
            "restaurant_id"          => "1",
            "user_id"                => "1",
        ],
        [
            "type"                   => '5',
            "source_balance_id"      => '1',
            "destination_balance_id" => '1',
            "amount"                 => '22.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"0b044a53-433b-4f36-a0b6-870474ad03f7","order_id":4,"restaurant_id":1,"user_id":1}',
            "invoice_id"             => "0b044a53-433b-4f36-a0b6-870474ad03f7",
            "order_id"               => "4",
            "restaurant_id"          => "1",
            "user_id"                => "1",
        ],
        [
            "type"                   => '15',
            "source_balance_id"      => '1',
            "destination_balance_id" => '7',
            "amount"                 => '38.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"f42148dc-6842-4f2d-8e79-4038c5f8d4fa","order_id":6,"restaurant_id":1,"user_id":2}',
            "invoice_id"             => "f42148dc-6842-4f2d-8e79-4038c5f8d4fa",
            "order_id"               => "6",
            "restaurant_id"          => "1",
            "user_id"                => "2",
        ],


        [
            "type"                   => '1',
            "source_balance_id"      => '0',
            "destination_balance_id" => '2',
            "amount"                 => '52.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":5,"invoice_id":"f42148dc-6842-4f2d-8e79-4038c5f8d4fa","order_id":6,"restaurant_id":1,"user_id":2}',
            "invoice_id"             => "f42148dc-6842-4f2d-8e79-4038c5f8d4fa",
            "order_id"               => "6",
            "restaurant_id"          => "1",
            "user_id"                => "2",
        ],
        [
            "type"                   => '5',
            "source_balance_id"      => '2',
            "destination_balance_id" => '1',
            "amount"                 => '52.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"f42148dc-6842-4f2d-8e79-4038c5f8d4fa","order_id":6,"restaurant_id":1,"user_id":2}',
            "invoice_id"             => "f42148dc-6842-4f2d-8e79-4038c5f8d4fa",
            "order_id"               => "6",
            "restaurant_id"          => "1",
            "user_id"                => "2",
        ],
        [
            "type"                   => '1',
            "source_balance_id"      => '0',
            "destination_balance_id" => '2',
            "amount"                 => '32.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":"15","invoice_id":"c389492f-b21c-43e7-a16a-a3a37ce86ec9","order_id":7,"restaurant_id":1,"user_id":2}',
            "invoice_id"             => "c389492f-b21c-43e7-a16a-a3a37ce86ec9",
            "order_id"               => "7",
            "restaurant_id"          => "1",
            "user_id"                => "2",
        ],
        [
            "type"                   => '5',
            "source_balance_id"      => '2',
            "destination_balance_id" => '1',
            "amount"                 => '32.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"c389492f-b21c-43e7-a16a-a3a37ce86ec9","order_id":7,"restaurant_id":1,"user_id":2}',
            "invoice_id"             => "c389492f-b21c-43e7-a16a-a3a37ce86ec9",
            "order_id"               => "7",
            "restaurant_id"          => "1",
            "user_id"                => "2",
        ],
        [
            "type"                   => '1',
            "source_balance_id"      => '0',
            "destination_balance_id" => '2',
            "amount"                 => '22.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"c389492f-b21c-43e7-a16a-a3a37ce86ec9","order_id":7,"restaurant_id":1,"user_id":2}',
            "invoice_id"             => "4d317537-6c12-4787-8687-482e52fba78b",
            "order_id"               => "8",
            "restaurant_id"          => "1",
            "user_id"                => "2",
        ],

        [
            "type"                   => '5',
            "source_balance_id"      => '2',
            "destination_balance_id" => '1',
            "amount"                 => '22.00',
            "status"                 => "1",
            "meta"                   => '{"payment_method":20,"invoice_id":"4d317537-6c12-4787-8687-482e52fba78b","order_id":8,"restaurant_id":1,"user_id":2}',
            "invoice_id"             => "4d317537-6c12-4787-8687-482e52fba78b",
            "order_id"               => "8",
            "restaurant_id"          => "1",
            "user_id"                => "2",
        ],


    ];

    /**
     * Run the database seeds.
     */
    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->transactions as $transaction) {
                Transaction::insert([
                    'type'                   => $transaction['type'],
                    'source_balance_id'      => $transaction['source_balance_id'],
                    'destination_balance_id' => $transaction['destination_balance_id'],
                    'amount'                 => $transaction['amount'],
                    'status'                 => $transaction['status'],
                    'meta'                   => $transaction['meta'],
                    'invoice_id'             => $transaction['invoice_id'],
                    'order_id'               => $transaction['order_id'],
                    'restaurant_id'          => $transaction['restaurant_id'],
                    'user_id'                => $transaction['user_id'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
