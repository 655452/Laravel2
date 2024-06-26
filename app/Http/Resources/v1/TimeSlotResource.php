<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class TimeSlotResource extends JsonResource
{

    public function toArray($request)
    {


        $result = [
            'id'             => $this['id'],
            'start_time'     => $this['start_time'],
            'end_time'       => $this['end_time'],
            'startTime'      => date('h:i A', strtotime($this['start_time'])),
            'endTime'        => date('h:i A', strtotime($this['end_time'])),
        ];

        return $result;
    }
}
