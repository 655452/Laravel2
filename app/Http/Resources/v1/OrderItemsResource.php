<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
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

            'id'                => $this->id,
            'order_id'          => (int)$this->order_id,
            'restaurant_id'     => (int)$this->restaurant_id,
            'menu_item_id'        => (int)$this->menu_item_id,
            'quantity'          => (int)$this->quantity,
            'unit_price'        => $this->unit_price,
            'discounted_price'  => $this->discounted_price,
            'item_total'        => $this->item_total,
            'created_at'        => $this->created_at->format('d M Y, h:i A'),
            'updated_at'        => $this->updated_at->format('d M Y, h:i A'),
            'menu_item'        => new MenuItemResource($this->menuItem),
            'menu_item_variation' => new MenuItemVariationResource($this->variation),
            'options'           => json_decode($this->options, true),
            'option_total'      => (int)$this->options_total,
        ];
    }
}
