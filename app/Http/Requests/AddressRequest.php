<?php

namespace App\Http\Requests;

use App\Enums\AddressType;
use App\Models\Address;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label'       => ['required', 'numeric'],
            'label_name'  => ['nullable', 'string'],
            'lat'         => ['required'],
            'long'        => ['required'],
            'new_address' => ['required', 'max:200'],
            'apartment'   => ['max:200'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->uniqueOtherLabel()) {
                $validator->errors()->add('label_name', 'This Label is already created!');
            }
            if (request('label') == AddressType::OTHER && blank(request('label_name'))) {
                $validator->errors()->add('label_name', 'This field is required!');
            }
        });
    }


    private function uniqueOtherLabel()
    {
        if (request('label') == AddressType::OTHER) {
            $address = Address::where(['user_id' => auth()->user()->id, 'label_name' => request('label_name')])->first();
            if ($address && $address->id != request('id')) {
                return true;
            }
        }
        return false;
    }
}
