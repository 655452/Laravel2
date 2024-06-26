<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"                   => $this->id,
            "restaurant_id"            => $this->restaurant_id,
            "discount_type"        => $this->discount_type,
            "coupon_type"          => $this->coupon_type,
            "coupon_type_name"     => trans('coupon_types.'.$this->coupon_type),
            "name"                 => $this->name,
            "slug"                 => $this->slug,
            "minimum_order_amount" => $this->minimum_order_amount,
            "amount"               => $this->amount,
        ];
    }
}
