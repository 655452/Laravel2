<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use App\Enums\DiscountStatus;
use App\Enums\CouponType;

class CouponSeeder extends Seeder
{
    public array $coupons = [
        [
            'name'                 => "Off30%",
            'slug'                 => "off30",
            'discount_type'        => DiscountStatus::ACTIVE,
            'coupon_type'          => CouponType::COUPON,
            'restaurant_id'        => "1",
            'limit'                => "200",
            'user_limit'           => "100",
            'amount'               => "30.00",
            'minimum_order_amount' => "10.00",
            'from_date'            => "2023-11-18 15:01:00",
            'to_date'              => "2024-11-19 15:01:00",
            'creator_type'         => "App\Models\User",
            'creator_id'           => "1",
            'editor_type'          => "App\Models\User",
            'editor_id'            => "1",
        ],
        [
            'name'                 => "Off40%",
            'slug'                 => "off40",
            'discount_type'        => DiscountStatus::CANCELED,
            'coupon_type'          => CouponType::VOUCHER,
            'restaurant_id'        => "2",
            'limit'                => "200",
            'user_limit'           => "10",
            'amount'               => "40.00",
            'minimum_order_amount' => "10.00",
            'from_date'            => "2023-11-18 15:03:00",
            'to_date'              => "2024-11-19 15:03:00",
            'creator_type'         => "App\Models\User",
            'creator_id'           => "1",
            'editor_type'          => "App\Models\User",
            'editor_id'            => "1",
        ],
        [
            'name'                 => "Off40%",
            'slug'                 => "off40-1",
            'discount_type'        => DiscountStatus::CANCELED,
            'coupon_type'          => CouponType::VOUCHER,
            'restaurant_id'        => "3",
            'limit'                => "20",
            'user_limit'           => "10",
            'amount'               => "20.00",
            'minimum_order_amount' => "50.00",
            'from_date'            => "2023-11-18 15:01:00",
            'to_date'              => "2024-11-19 15:01:00",
            'creator_type'         => "App\Models\User",
            'creator_id'           => "1",
            'editor_type'          => "App\Models\User",
            'editor_id'            => "1",
        ],
        [
            'name'                 => "Off30%",
            'slug'                 => "off30-1",
            'discount_type'        => DiscountStatus::ACTIVE,
            'coupon_type'          => CouponType::COUPON,
            'restaurant_id'        => "4",
            'limit'                => "20",
            'user_limit'           => "1",
            'amount'               => "10.00",
            'minimum_order_amount' => "40.00",
            'from_date'            => "2023-11-18 15:01:00",
            'to_date'              => "2024-11-19 15:01:00",
            'creator_type'         => "App\Models\User",
            'creator_id'           => "1",
            'editor_type'          => "App\Models\User",
            'editor_id'            => "1",
        ],
        [
            'name'                 => "Off40%",
            'slug'                 => "off40-2",
            'discount_type'        => DiscountStatus::ACTIVE,
            'coupon_type'          => CouponType::COUPON,
            'restaurant_id'        => "5",
            'limit'                => "150",
            'user_limit'           => "10",
            'amount'               => "30.00",
            'minimum_order_amount' => "10.00",
            'from_date'            => "2023-11-18 15:01:00",
            'to_date'              => "2024-11-19 15:01:00",
            'creator_type'         => "App\Models\User",
            'creator_id'           => "1",
            'editor_type'          => "App\Models\User",
            'editor_id'            => "1",
        ],
        [
            'name'                 => "Off40%",
            'slug'                 => "off40-3",
            'discount_type'        => DiscountStatus::ACTIVE,
            'coupon_type'          => CouponType::COUPON,
            'restaurant_id'        => "6",
            'limit'                => "200",
            'user_limit'           => "100",
            'amount'               => "30.00",
            'minimum_order_amount' => "10.00",
            'from_date'            => "2023-11-18 15:01:00",
            'to_date'              => "2024-11-19 15:01:00",
            'creator_type'         => "App\Models\User",
            'creator_id'           => "1",
            'editor_type'          => "App\Models\User",
            'editor_id'            => "1",
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->coupons as $coupon) {
                Coupon::create([
                    'name'                 => $coupon['name'],
                    'slug'                 => $coupon['slug'],
                    'discount_type'        => $coupon['discount_type'],
                    'coupon_type'          => $coupon['coupon_type'],
                    'restaurant_id'        => $coupon['restaurant_id'],
                    'user_limit'           => $coupon['user_limit'],
                    'amount'               => $coupon['amount'],
                    'minimum_order_amount' => $coupon['minimum_order_amount'],
                    'from_date'            => $coupon['from_date'],
                    'to_date'              => $coupon['to_date'],
                    'creator_type'         => $coupon['creator_type'],
                    'creator_id'           => $coupon['creator_id'],
                    'editor_type'          => $coupon['editor_type'],
                    'editor_id'            => $coupon['editor_id'],
                ]);
            }
        }
    }
}
