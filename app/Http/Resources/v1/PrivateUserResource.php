<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PrivateUserResource extends JsonResource
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
            'status'  => 200,
            'message' => 'Successfully Login',
            'data'    => [
                'id'       => $this->id,
                'name'     => $this->name,
                'email'    => $this->email,
                'phone'    => $this->phone,
                'username' => $this->username,
                'image'    => $this->image,
                'address'  => $this->address,
                'status'   => (int)$this->status,
                'applied'  => (int)$this->applied,
                'myrole'   => $this->getrole->name,
                'mystatus' => $this->mystatus,
            ],
        ];
    }
}
