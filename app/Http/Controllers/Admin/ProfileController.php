<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Bank;
use App\Models\Order;
use App\Models\Address;
use App\Helpers\Support;
use App\Enums\AddressType;
use Illuminate\Http\Request;
use App\Http\Requests\BankRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BackendController;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends BackendController
{
    public function index()
    {
        $orderCOunt = 0;
        $bank = null;
        if (auth()->user()->myrole == 4) {
            $orderCOunt = Order::where(['delivery_boy_id' => auth()->user()->id])->latest()->get()->count();
            $bank = auth()->user()->bank;
        } elseif (auth()->user()->myrole == 3) {
            $orderCOunt = Order::orderBy('id', 'desc')->where('restaurant_id', auth()->user()->restaurant->id)->get()->count();
            $bank = auth()->user()->bank;
        } else {
            $orderCOunt = Order::orderBy('id', 'desc')->get()->count();
        }
        $this->data['ordercount'] = $orderCOunt;
        $this->data['bank'] = $bank;
        $this->data['user'] = auth()->user();
        return view('admin.profile.index', $this->data);

    }

    public function update(ProfileRequest $request)
    {
        $user             = auth()->user();

        $user->first_name = $request->get('first_name');
        $user->last_name  = $request->get('last_name');
        $user->email      = $request->get('email');
        $user->phone      = $request->get('phone');
        $user->username   = $request->username ?? generateUsername($request->email);
        $user->address    = $request->get('address');
        $user->save();

        if($user->address != $request->get('address')){
            Address::create([
                'label' => AddressType::HOME,
                'address' => $request->get('address'),
                'label_name' => trans('address_types.' . AddressType::HOME),
                'user_id' => $user->id,
            ]);
        }

        if ($request->file('image')) {
            $user->deleteMedia('user', $user->id);
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        return redirect(route('admin.profile'))->withSuccess('The Data Updated Successfully');
    }

    public function change(ChangePasswordRequest $request)
    {
        $user           = auth()->user();
        $user->password = Hash::make(request('password'));
        $user->save();
        return redirect(route('admin.profile'))->withSuccess('The Password updated successfully');
    }

    public function saveAddress(Request $request)
    {
        $retArray['status']  = false;
        $retArray['message'] = '';

        $validator = Validator::make($request->all(), $this->addressRule());

        $validator->after(function ($validator) {
            if ($this->checkLabelAddress()) {
                $validator->errors()->add(
                    'label',
                    'The address label already added.'
                );
            }
        });

        if ($validator->fails()) {
            $errorArray   = $validator->errors()->toArray();
            $errorMessage = [];
            if (!blank($errorArray)) {
                foreach ($errorArray as $key => $value) {
                    $errorMessage[$key] = $value[0] ?? '';
                }
                $retArray['message'] = end($errorMessage);
            }
            $retArray['errors'] = $errorMessage;
        } else {
            $retArray['message'] = 'The address inserted successfully.';
            $address             = new Address;
            if ((int) $request->id) {
                $address = Address::find($request->id);
                if (!blank($address)) {
                    $retArray['message'] = 'The address updated successfully.';
                }
            }
            $address->label     = $request->label;
            $address->street    = $request->street;
            $address->note      = $request->note;
            $address->latitude  = $request->latitude;
            $address->longitude = $request->longitude;
            $address->user_id   = auth()->id();
            $address->save();

            $retArray['status'] = true;
            $request->session()->flash('success', $retArray['message']);
        }
        echo json_encode($retArray);
    }

    private function addressRule()
    {
        return [
            'label'     => ['required', 'numeric'],
            'street'    => ['required', 'string', 'max:200'],
            'note'      => ['nullable', 'string', 'max:200'],
            'latitude'  => ['nullable', 'string', 'max:32'],
            'longitude' => ['nullable', 'string', 'max:32'],
        ];
    }

    public function deleteAddress($id)
    {
        Address::findOrFail($id)->delete();
        return redirect(route('admin.profile'))->withSuccess('The Data Deleted Successfully');
    }

    private function checkLabelAddress()
    {
        if (request('id')) {
            $address = Address::where(['user_id' => auth()->id(), 'label' => request('label')])->where('id', '!=', request('id'))->first();
        } else {
            $address = Address::where(['user_id' => auth()->id(), 'label' => request('label')])->first();
        }
        if (!blank($address)) {
            return true;
        }
        return false;
    }

    public function profileBank(BankRequest $request, Bank $bank)
    {


        $bank->user_id             = $request->user_id;
        $bank->bank_name           = $request->bank_name;
        $bank->bank_code           = $request->bank_code;
        $bank->recipient_name      = $request->recipient_name;
        $bank->account_number      = $request->account_number;
        $bank->mobile_agent_name   = $request->mobile_agent_name;
        $bank->mobile_agent_number = $request->mobile_agent_number;
        $bank->paypal_id           = $request->paypal_id;
        $bank->upi_id              = $request->upi_id;
        $bank->save();
        return redirect(route('admin.profile'))->withSuccess('The data updated successfully.');
    }
}
