<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WithdrawRequest extends FormRequest
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
            'user_id'      => ['required', 'numeric'],
            'amount'       => ['required', 'digits_between: 1,10'],
            'payment_type' => ['required', 'numeric'],
        ];
    }

    public function withValidator($validator)
    {
        return $validator->after(function ($validator) {
            $this->checkBalanceAmount($validator);
        });
    }

    public function checkBalanceAmount($validator)
    {
        $user = User::find(request('user_id'));
        if (!blank($user)) {
            $balanceAmount = $user->balance->balance;
            if ($balanceAmount < request('amount')) {
                $validator->errors()->add('amount', 'The amount can not greater than to balance amount ' . $balanceAmount);
            }
        }
    }

    public function attributes()
    {
        return [
            'user_id'      => trans('validation.attributes.user_id'),
            'amount'       => trans('validation.attributes.amount'),
            'payment_type' => trans('validation.attributes.payment_type'),
        ];
    }
}
