<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class TableResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray( $request )
    {
        if ( $this->resource instanceof Collection ) {
            return TableResource::collection($this->resource);
        }

        $result = [
            'id'             => $this->id,
            'name'           => $this->name,
            'capacity'      => $this->capacity,
            'status'      => (int)$this->status,
            'restaurant_id'      => (int)$this->restaurant_id,
        ];

        return $result;
    }

}
