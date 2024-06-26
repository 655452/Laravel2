<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "id"         => $this->id,
            "label"      => $this->label,
            "label_name" => $this->label_name,
            "address"    => $this->address,
            "apartment"  => $this->apartment,
            "lat"        => $this->latitude,
            "long"       => $this->longitude,

        ];
    }
}
