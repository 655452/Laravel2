<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CuisineResource extends JsonResource
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
            "id"          => $this->id,
            "name"       => $this->name,
            "slug"        => $this->slug,
            "image"        => $this->image,
            "description" => strip_tags($this->description),
        ];
    }
}
