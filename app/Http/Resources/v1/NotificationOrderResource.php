<?php


namespace App\Http\Resources\v1;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'order_code'          => $this->order_code,
            'user_id'             => (int)$this->user_id,
            'total'               => $this->total,
            'sub_total'           => $this->sub_total,
            'delivery_charge'     => $this->delivery_charge,
            'status'              => (int)$this->status,
            'status_name'         => trans('order_status.' . $this->status),
            'payment_status'      => (int)$this->payment_status,
            'paid_amount'         => $this->paid_amount,
            'address'             => $this->address,
            'mobile'              => $this->mobile,
            'lat'                 => $this->lat,
            'long'                => $this->long,
            'misc'                => $this->misc,
            'payment_method'      => (int)$this->payment_method,
            'payment_method_name' => trans('payment_method.' . $this->payment_method),
            'created_at'          => Carbon::parse($this->created_at)->format('d M Y h:i A'),
            'updated_at'          => Carbon::parse($this->updated_at)->format('d M Y h:i A'),
            'invoice_id'          => $this->invoice_id,
            'shop_id'             => (int)$this->restaurant_id,
            'delivery_boy_id'     => (int)$this->delivery_boy_id,
            'product_received'    => (int)$this->product_received,
            'time_format'         => $this->created_at->diffForHumans(),
            'date'                => Carbon::parse($this->created_at)->format('d M Y')
        ];
    }
}
