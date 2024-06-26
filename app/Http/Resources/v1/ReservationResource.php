<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray( $request )
    {
        return [
            "id"                      => $this->id,
            "name"                    => $this->first_name.' '.$this->last_name,
            "email"                   => $this->email,
            "phone"                   => $this->phone,
            "status"                  => (int)$this->status,
            'status_name'             => trans('reservation_status.' . $this->status),
            "reservation_date"        => date('d M Y',strtotime($this->reservation_date)),
            "slot"                    => date('h:i A', strtotime($this->timeSlot->start_time)).'-'.date('h:i A', strtotime($this->timeSlot->end_time)),
            "table"                   => $this->table->name,
            "guest"                   => (int)$this->guest_number,
            "restaurant_address"      => $this->restaurant->address,
            "restaurant_name"         => $this->restaurant->name,
            "restaurant_phone"        => $this->restaurant->user->phone,
            "restaurant_email"        => $this->restaurant->user->email,
            "restaurant_opening_time" => Carbon::parse($this->opening_time)->format('h:i A'),
            "restaurant_closing_time" => Carbon::parse($this->closing_time)->format('h:i A'),

        ];
    }
}
