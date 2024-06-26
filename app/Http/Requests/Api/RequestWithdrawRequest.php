<?php

namespace App\Http\Requests\Api;

use App\Enums\RequestWithdrawStatus;
use App\Models\RequestWithdraw;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestWithdrawRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'gt:0'],
            'date'   => ['required', 'date', 'after_or_equal:today'],
            'status' => ['nullable', 'numeric']
        ];
    }


    public function withValidator($validator)
    {
        if (!is_numeric(request('amount'))) {
            return   $validator->errors()->add('amount', 'Amount must be numeric.');
        }
        return $validator->after(function ($validator) {
            $this->checkBalanceAmount($this->request_withdraw, $validator);
        });
    }

    public function checkBalanceAmount($requestWithdrawId, $validator)
    {

        $user = User::find(auth()->id());
        $amount  = 0;
        $user_id = 0;
        $requestWithdraw = [];
        if ($requestWithdrawId) {
            $requestWithdraw = RequestWithdraw::find($requestWithdrawId);
            if (!blank($requestWithdraw)) {
                $amount  = $requestWithdraw->user->balance->balance;
                $user_id = $requestWithdraw->user_id;
            }
        } else {
            $amount  = $user->balance->balance;
            $user_id = $user->id;
        }
        $requestWithdrawAmount = RequestWithdraw::where(['user_id' => $user_id, 'status' => RequestWithdrawStatus::PENDING])->sum('amount');

        if ($requestWithdrawId) {
            $requestWithdrawAmount -= $requestWithdraw->amount;
        }

        $requestAmount         = $requestWithdrawAmount + request('amount');

        if ($amount >= $requestAmount) {
            return false;
        }

        $remainAmount = $amount - $requestWithdrawAmount;
        if ($remainAmount <= 0) {
            $validator->errors()->add('amount', 'Your available balance amount is 0.');
        } else {
            $validator->errors()->add('amount', 'The amount can not greater than to balance amount ' . $remainAmount);
        }
    }

    public function attributes()
    {
        return [
            'amount' => trans('validation.attributes.amount'),
            'date'   => trans('validation.attributes.date'),
            'status' => trans('validation.attributes.status'),
        ];
    }
}
