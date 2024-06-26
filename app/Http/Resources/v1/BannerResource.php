<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'restaurant_id'   => (int)$this->restaurant_id,
            'title'           => $this->title,
            'link'            => $this->link,
            'sort'            => $this->sort,
            'status'          => (int)$this->status,
            'description'     => strip_tags($this->short_description),
            'created_at'      => $this->created_at->format('d M Y, h:i A'),
            'updated_at'      => $this->updated_at->format('d M Y, h:i A'),
            'image'           => $this->image,
        ];
    }
}
