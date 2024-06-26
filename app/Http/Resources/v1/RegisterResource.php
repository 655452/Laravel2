<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 19/4/20
 * Time: 4:19 PM
 */

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
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
            'message' => 'Successfully Register',
            'data'    => [
                'id'       => $this->id,
                'email'    => $this->email,
                'username' => $this->username,
                'phone'    => $this->phone,
                'address'  => $this->address,
                'name'     => $this->first_name . ' ' . $this->last_name,
                "balance"  => $this->balance->balance,
                'status'   => (int)$this->status,
                'applied'  => (int)$this->applied,
                'image'    => $this->image,
                'myrole'   => $this->getrole->name,
            ],
        ];
    }
}
