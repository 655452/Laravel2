<?php

namespace App\Http\Requests;

use App\Models\DeliveryBoyAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionRequest extends FormRequest
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
            'user_id' => ['required', 'numeric', 'not_in:0'],
            'date'    => ['required'],
            'amount'  => ['required', 'numeric', 'not_in:0'],
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => trans('validation.attributes.name'),
            'date'    => trans('validation.attributes.date'),
            'amount'  => trans('validation.attributes.amount'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->amountCheck()) {
                $validator->errors()->add('amount', 'The amount is larger than balance amount.');
            }
        });
    }

    private function amountCheck()
    {
        $user_id = request('user_id');
        $amount  = request('amount');

        $deliveryBoyAccount = DeliveryBoyAccount::where('user_id', $user_id)->first();

        if (!blank($deliveryBoyAccount) && ($amount > $deliveryBoyAccount->balance)) {
            return true;
        }
        return false;
    }

}
