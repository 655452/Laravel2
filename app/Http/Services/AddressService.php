<?php


namespace App\Http\Services;

use App\Enums\AddressType;
use App\Models\Address;

class AddressService
{
    public $data = [];
    public function allAddresses()
    {
        $this->data['addresses'] = Address::where('user_id',auth()->user()->id)->get();
        return $this->data['addresses'];
    }


    public function store($request)
    {
        $previousAddress = Address::where(['label'=>$request->label,'user_id'=>auth()->user()->id])->first();
        if(!blank($previousAddress)){
            $previousAddress->label = AddressType::OTHER;
            $previousAddress->label_name = "";
            $previousAddress->save();
        }
        $address             = new Address;
        $address->label      = $request->label;
        $address->label_name = ($request->label == AddressType::OTHER) ?  $request->label_name : trans('address_types.'.$request->label);
        $address->address    = $request->new_address;
        $address->apartment  = $request->apartment;
        $address->latitude   = $request->lat;
        $address->longitude  = $request->long;
        $address->user_id    = auth()->user()->id;
        $address->save();

        return $address;
    }

    public function update($address,$request)
    {
        $address->label      = $request->label;
        $address->label_name = ($request->label == AddressType::OTHER) ?  $request->label_name : trans('address_types.'.$request->label);
        $address->address    = $request->new_address;
        $address->apartment  = $request->apartment;
        $address->latitude   = $request->lat;
        $address->longitude  = $request->long;
        $address->user_id    = auth()->user()->id;
        $address->save();

        return $address;
    }



}
