<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 19/4/20
 * Time: 4:10 PM
 */

namespace App\Http\Resources\v1;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
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
            'status' => 200,
            'data'   => [
                'id'       => $this->id,
                'email'    => $this->email,
                'username' => $this->username,
                'phone'    => $this->phone,
                'address'  => $this->address,
                'name'     => $this->first_name . ' ' . $this->last_name,
                'status'   => (int)$this->status,
                'applied'  => (int)$this->applied,
                'totalOrders'  => auth()->user()->myrole ==4?$this->orderCount():$this->orders()->count(),
                'totalReservations'  => $this->reservations()->count(),
                'image'    => $this->image,
                'myrole'   => $this->getrole->name,
                "balance"  => currencyFormat($this->balance->balance),
                'deposit_amount'   => isset($this->deposit->deposit_amount) ? currencyFormat($this->deposit->deposit_amount) : '',
                'limit_amount'   => isset($this->deposit->limit_amount) ? currencyFormat($this->deposit->limit_amount) : '',
                'mystatus'   => $this->mystatus,
                'restaurant' =>  !blank($this->restaurant) ? new RestaurantResource($this->restaurant) : [],

        ],
        ];
    }

    private function orderCount(){
        $orders = Order::where(['delivery_boy_id' => auth()->user()->id])->latest()->get();
        return $orders->count();
    }

}
