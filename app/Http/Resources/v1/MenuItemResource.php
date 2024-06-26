<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class MenuItemResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray( $request )
    {
        return [
            "id"                => $this->id,
            "name"              => $this->name,
            "slug"              => $this->slug,
            "menu_number"       => $this->menu_number,
            "unit_price"        => $this->unit_price,
            "discount_price"    => $this->discount_price,
            "currency_code"     => setting('currency_code'),
            "image"             => $this->image,
            "description"       => strip_tags($this->description),
            'variations'      => MenuItemVariationResource::collection($this->variations),
            'options'         => $this->options!=null?MenuItemOptionResource::collection($this->options):[],
        ];
    }

}
