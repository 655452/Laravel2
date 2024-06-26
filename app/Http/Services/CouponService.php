<?php


namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Discount;
use App\Enums\CouponType;

class CouponService
{

    public function coupons()
    {
        $today = date('Y-m-d h:i:s');
        $this->data['coupons'] = Coupon::where('coupon_type', CouponType::COUPON)->whereDate('to_date', '>', $today)->whereDate('from_date', '<', $today)->where('limit', '>', 0)->descending()->get();
        return $this->data['coupons'];
    }

    public function vouchers($id)
    {
        $today = date('Y-m-d h:i:s');
        $this->data['voucher'] = Coupon::where('coupon_type', CouponType::VOUCHER)->whereDate('to_date', '>', $today)->whereDate('from_date', '<', $today)->where('limit', '>', 0)->where('restaurant_id', $id)->descending()->get();
        return $this->data['voucher'];
    }

    public function show($id)
    {
        return Coupon::with('discounts')->findOrFail($id);
    }

    public function store($request)
    {
        $coupon                       = new Coupon;
        $coupon->name                 = $request->name;
        $coupon->discount_type        = $request->discount_type;
        $coupon->coupon_type          = ($request->restaurant_id == 0) ? CouponType::COUPON : CouponType::VOUCHER;
        $coupon->limit                = $request->limit;
        $coupon->user_limit           = $request->user_limit;
        $coupon->amount               = $request->amount;
        $coupon->minimum_order_amount = $request->minimum_order_amount;
        $coupon->restaurant_id            = $request->restaurant_id;
        $coupon->from_date            = $request->from_date;
        $coupon->to_date              = $request->to_date;
        $coupon->save();

        return $coupon;
    }

    public function update($id, $request)
    {
        $coupon                       = Coupon::findOrFail($id);
        $coupon->name                 = $request->name;
        $coupon->discount_type        = $request->discount_type;
        $coupon->coupon_type          = ($request->restaurant_id == 0) ? CouponType::COUPON : CouponType::VOUCHER;
        $coupon->limit                = $request->limit;
        $coupon->user_limit           = $request->user_limit;
        $coupon->amount               = $request->amount;
        $coupon->minimum_order_amount = $request->minimum_order_amount;
        $coupon->restaurant_id            = $request->restaurant_id;
        $coupon->from_date            = $request->from_date;
        $coupon->to_date              = $request->to_date;
        $coupon->save();

        return $coupon;
    }

    public function singleRestaurantCoupon($id)
    {
        $response = ['status' => false];

        $today = date('Y-m-d h:i:s');
        $restaurant_id = $id;

        $coupons = Coupon::where('restaurant_id', $restaurant_id)
            ->whereDate('to_date', '>=', $today)
            ->whereDate('from_date', '<=', $today)
            ->where('limit', '>', 0)
            ->get();

        $data = [];
        if (!blank($coupons)) {
            foreach ($coupons as $coupon) {
                $total_used = Discount::where('coupon_id', $coupon->id)->where('status', \App\Enums\DiscountStatus::ACTIVE)->count();
                if ($total_used < $coupon->limit) {
                    $data[] = $coupon;
                }
            }
        }
        return $data;
    }

    public function allCoupons()
    {
        $today = date('Y-m-d h:i:s');

        $coupons = Coupon::where('coupon_type', CouponType::COUPON)
            ->whereDate('to_date', '>=', $today)
            ->whereDate('from_date', '<=', $today)
            ->where('limit', '>', 0)
            ->get();

        $data = [];
        if (!blank($coupons)) {
            foreach ($coupons as $coupon) {
                $total_used = Discount::where('coupon_id', $coupon->id)->where('status', \App\Enums\DiscountStatus::ACTIVE)->count();
                if ($total_used < $coupon->limit) {
                    $data[] = $coupon;
                }
            }
        }
        return $data;
    }
}