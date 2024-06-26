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

class DeliveryboyOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'order_code'       => $this->order_code,
            'user_id'          => (int)$this->user_id,
            'total'            => $this->total,
            'sub_total'        => $this->sub_total,
            'delivery_charge'  => $this->delivery_charge,
            'status'           => (int)$this->status,
            'status_name'      => trans('order_status.' . $this->status),
            'order_type'       =>  (int)$this->order_type,
            'order_type_name'  =>  $this->getOrderType,
            'platform'         => $this->platform,
            'device_id'        => $this->device_id,
            'ip'               => $this->ip,
            'payment_status'   => (int)$this->payment_status,
            'payment_method_name'    => trans('payment_method.' . $this->payment_method),
            'paid_amount'      => $this->paid_amount,
            'address'          => $this->address,
            'mobile'           => $this->mobile,
            'lat'              => $this->lat,
            'long'             => $this->long,
            'misc'             => $this->misc,
            'payment_method'   => $this->payment_method,
            'invoice_id'       => $this->invoice_id,
            'delivery_boy_id'  => (int)$this->delivery_boy_id,
            'shop_id'          => (int)$this->restaurant_id,
            'product_received' => (int)$this->product_received,
            'created_at'       => $this->created_at->format('d M Y, h:i A'),
            'updated_at'       => $this->updated_at->format('d M Y, h:i A'),
            'time_format'           => $this->created_at->diffForHumans(),
            'date'                  => Carbon::parse($this->created_at)->format('d M Y'),
            'customer'         => new UserResource($this->user),
            'restaurant'       => new RestaurantResource($this->restaurant),
        ];
    }
}
