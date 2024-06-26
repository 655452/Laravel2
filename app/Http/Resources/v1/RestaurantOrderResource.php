<?php

/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 18/4/20
 * Time: 2:07 PM
 */

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return   [
            'id'               => $this->id,
            'order_code'       => $this->order_code,
            'user_id'          => (int)$this->user_id,
            'total'            => $this->total,
            'sub_total'        => $this->sub_total,
            'delivery_charge'  => $this->delivery_charge,
            'platform'         => $this->platform,
            'device_id'        => $this->device_id,
            'ip'               => $this->ip,
            'status'           => (int)$this->status,
            'status_name'      => trans('order_status.' . $this->status),
            'order_type'       =>  (int)$this->order_type,
            'order_type_name'  =>  $this->getOrderType,
            'payment_status'   => $this->payment_status,
            'payment_method'   => $this->payment_method,
            'payment_method_name'    => trans('payment_method.' . $this->payment_method),
            'paid_amount'      => $this->paid_amount,
            'address'          => $this->address,
            'invoice_id'       => $this->invoice_id,
            'delivery_boy_id'   => (int)$this->delivery_boy_id,
            'restaurant_id'    => (int)$this->restaurant_id,
            'product_received' => $this->product_received,
            'mobile'           => $this->mobile,
            'lat'              => $this->lat,
            'long'             => $this->long,
            'created_at'       => $this->created_at->format('d M Y, h:i A'),
            'updated_at'       => $this->updated_at->format('d M Y, h:i A'),
            'time_format'           => $this->created_at->diffForHumans(),
            'date'                  => Carbon::parse($this->created_at)->format('d M Y'),
            'items'            => OrderItemsResource::collection(
                $this->whenLoaded('items')
            ),
            'deliveryBoy' => $this->delivery_boy_id == null?null:new UserResource($this->delivery),

        ];

    }
}
