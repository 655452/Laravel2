<?php

namespace App\Http\Resources\v1;
use Carbon\Carbon;


use Illuminate\Support\Collection;
use App\Http\Resources\v1\CouponResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"                   => $this->id,
            "name"                 => $this->name,
            "user_id"              => (int)$this->user_id,
            "description"          => strip_tags($this->description),
            "delivery_charge"      => setting('basic_delivery_charge'),
            "free_delivery_radius" => setting('free_delivery_radius'),
            "charge_per_kilo"      => setting('charge_per_kilo'),
            "lat"                  => $this->lat,
            "long"                 => $this->long,
            "opening_time"         => Carbon::parse($this->opening_time)->format('h:i A'),
            "closing_time"         => Carbon::parse($this->closing_time)->format('h:i A'),
            "address"              => $this->address,
            "table_status"         => (int)$this->table_status,
            "delivery_status"      => (int)$this->delivery_status,
            "pickup_status"        => (int)$this->pickup_status,
            "status"               => trans('restaurant_statuses.' . $this->status),
            "current_status"       => trans('current_status.' . $this->current_status),
            'created_at'           => $this->created_at->format('d M Y, h:i A'),
            'updated_at'           => $this->updated_at->format('d M Y, h:i A'),
            "image"                => $this->image,
            "logo"                 => $this->logo,
            "cuisines"             => CuisineResource::collection($this->cuisines),
        ];

    }

}
