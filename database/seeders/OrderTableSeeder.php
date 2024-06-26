<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\OrderTypeStatus;
use App\Enums\ProductReceiveStatus;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    public array $orders = [

        [
            'user_id'          => "1",
            'total'            => "42.00",
            'sub_total'        => "30.00",
            'delivery_charge'  => "12.00",
            'status'           => OrderStatus::COMPLETED,
            'platform'         => NULL,
            'order_type'       => OrderTypeStatus::DELIVERY,
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => PaymentStatus::PAID,
            'paid_amount'      => "42.00",
            'address'          => '{"address":"R944+4X3, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "8801881896743",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000011","remarks":""}',
            'invoice_id'       => "aa361d9c-f98f-420c-88bf-0557e191e54f",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => '4',
            'product_received' => ProductReceiveStatus::RECEIVE,
            'payment_method'   => PaymentMethod::CASH_ON_DELIVERY,
        ],

        [
            'user_id'          => "1",
            'total'            => "102.00",
            'sub_total'        => "90.00",
            'delivery_charge'  => "12.00",
            'status'           => '20',
            'platform'         => NULL,
            'order_type'       => '1',
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => '5',
            'paid_amount'      => "102.00",
            'address'          => '{"address":"17 Rd No. 5, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "880113286749",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000028","remarks":""}',
            'invoice_id'       => "aa361d9c-f98f-420c-88bf-0557e191e54f",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => '4',
            'product_received' => '5',
            'payment_method'   => '15',
        ],

        [
            'user_id'          => "1",
            'total'            => "42.00",
            'sub_total'        => "30.00",
            'delivery_charge'  => "12.00",
            'status'           => '12',
            'platform'         => NULL,
            'order_type'       => '1',
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => '10',
            'paid_amount'      => "0.00",
            'address'          => '{"address":"17 Rd No. 5, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "8801354345645",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000034","remarks":""}',
            'invoice_id'       => "9e15a20a-db17-4782-adfe-4d84ba5c68d7",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => NULL,
            'product_received' => '10',
            'payment_method'   => '5',
        ],

        [
            'user_id'          => "1",
            'total'            => "22.00",
            'sub_total'        => "10.00",
            'delivery_charge'  => "12.00",
            'status'           => '20',
            'platform'         => NULL,
            'order_type'       => '1',
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => '5',
            'paid_amount'      => "22.00",
            'address'          => '{"address":"17 Rd No. 5, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "88015757534235",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000044","remarks":""}',
            'invoice_id'       => "90b044a53-433b-4f36-a0b6-870474ad03f7",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => '4',
            'product_received' => '5',
            'payment_method'   => '5',
        ],

        [
            'user_id'          => "1",
            'total'            => "102.00",
            'sub_total'        => "90.00",
            'delivery_charge'  => "12.00",
            'status'           => '5',
            'platform'         => NULL,
            'order_type'       => '1',
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => '10',
            'paid_amount'      => "0.00",
            'address'          => '{"address":"17 Rd No. 5, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "88015757534235",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000056","remarks":""}',
            'invoice_id'       => "33399cb5-9f10-45e7-8f61-904e7eab5195",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => NULL,
            'product_received' => '10',
            'payment_method'   => '5',
        ],

        [
            'user_id'          => "2",
            'total'            => "52.00",
            'sub_total'        => "40.00",
            'delivery_charge'  => "12.00",
            'status'           => '20',
            'platform'         => NULL,
            'order_type'       => '1',
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => '5',
            'paid_amount'      => "52.00",
            'address'          => '{"address":"17 Rd No. 5, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "8801575753423",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000068","remarks":""}',
            'invoice_id'       => "f42148dc-6842-4f2d-8e79-4038c5f8d4fa",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => '4',
            'product_received' => '5',
            'payment_method'   => '5',
        ],

        [
            'user_id'          => "2",
            'total'            => "32.00",
            'sub_total'        => "20.00",
            'delivery_charge'  => "12.00",
            'status'           => '14',
            'platform'         => NULL,
            'order_type'       => '1',
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => '5',
            'paid_amount'      => "32.00",
            'address'          => '{"address":"17 Rd No. 5, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "8801575753423",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000074","remarks":""}',
            'invoice_id'       => "c389492f-b21c-43e7-a16a-a3a37ce86ec9",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => NULL,
            'product_received' => '10',
            'payment_method'   => '15',
        ],

        [
            'user_id'          => "2",
            'total'            => "22.00",
            'sub_total'        => "10.00",
            'delivery_charge'  => "12.00",
            'status'           => '5',
            'platform'         => NULL,
            'order_type'       => '1',
            'device_id'        => NULL,
            'ip'               => NULL,
            'payment_status'   => '5',
            'paid_amount'      => "22.00",
            'address'          => '{"address":"17 Rd No. 5, Dhaka 1216, Bangladesh","apartment":"apartment 5\/6"}',
            'mobile'           => "8801575753423",
            'lat'              => "23.805151335301865",
            'long'             => "90.35741978836062",
            'misc'             => '{"order_code":"ORD-00000074","remarks":""}',
            'invoice_id'       => "4d317537-6c12-4787-8687-482e52fba78b",
            'restaurant_id'    => "1",
            'delivery_boy_id'  => NULL,
            'product_received' => '10',
            'payment_method'   => '15',
        ],

    ];












    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->orders as $order) {
                Order::create([
                    'user_id'          => $order['user_id'],
                    'total'            => $order['total'],
                    'sub_total'        => $order['sub_total'],
                    'delivery_charge'  => $order['delivery_charge'],
                    'status'           => $order['status'],
                    'platform'         => $order['platform'],
                    'order_type'       => $order['order_type'],
                    'device_id'        => $order['device_id'],
                    'ip'               => $order['ip'],
                    'payment_status'   => $order['payment_status'],
                    'paid_amount'      => $order['paid_amount'],
                    'mobile'           => $order['mobile'],
                    'lat'              => $order['lat'],
                    'long'             => $order['long'],
                    'misc'             => $order['misc'],
                    'invoice_id'       => $order['invoice_id'],
                    'restaurant_id'    => $order['restaurant_id'],
                    'delivery_boy_id'  => $order['delivery_boy_id'],
                    'product_received' => $order['product_received'],
                    'payment_method'   => $order['payment_method'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }

}
