<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'restaurant_id'     =>$this->restaurant_id,
            'rating'            =>$this->rating,
            'user_id'           =>(int)$this->user_id,
            'user'              =>$this->user->name,
            'userImage'         =>$this->user->image,
            'image'             =>$this->image,
            'review'            =>$this->review,
            'created_at'        =>$this->created_at->format('d M Y, h:i A'),
        ];
    }

}
