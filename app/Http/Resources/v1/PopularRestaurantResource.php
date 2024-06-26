<?php

namespace App\Http\Resources\v1;

use Illuminate\Support\Collection;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PopularRestaurantResource extends JsonResource
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
            "id"              => $this->id,
            "name"            => $this->name,
            "description"     => strip_tags($this->description),
            "address"         => $this->address,
            "image"           => $this->image,
            "avgRating"       => $this->avgRatings['avgRating'],
            "avgRatingUser"   => $this->avgRatings['countUser'],

        ];
    }
}
