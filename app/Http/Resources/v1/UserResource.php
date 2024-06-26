<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id"         => $this->id,
            "name"       => $this->name,
            "first_name" => $this->first_name,
            "last_name"  => $this->last_name,
            "email"      => $this->email,
            "phone"      => $this->phone,
            "roles"      => $this->roles,
            "address"    => $this->address,
            "username"   => $this->username,
            "balance"    => $this->balance->balance,
            "status"     => (int)$this->status,
            "applied"    => (int)$this->applied,
            "image"      => $this->image,
        ];
    }

}
