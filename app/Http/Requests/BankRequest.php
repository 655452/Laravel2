<?php

namespace App\Http\Requests;

use App\Models\Bank;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankRequest extends FormRequest
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

            'user_id'             => ['required', 'numeric'],
            'bank_name'           => ['required', 'string'],
            'bank_code'           => ['nullable', 'string'],
            'recipient_name'      => ['nullable', 'string'],
            'account_number'      => ['nullable', 'numeric'],
            'mobile_agent_name'   => ['nullable', 'string'],
            'mobile_agent_number' => ['nullable', 'numeric'],
            'paypal_id'           => ['nullable', 'string'],
            'upi_id'              => ['nullable', 'string'],
            
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->uniqueAccountNumber($this->bank)) {
                $validator->errors()->add('account_number', 'This Account Number is already used!');
            }
        });
    }

    private function uniqueAccountNumber($bankInfo)
    {
        
        $bank = Bank::where('account_number',request('account_number'))->first();
        if(!blank($bank)){
            if($bankInfo != null){
                return $bank->id == $bankInfo->id ? false : true;
            }
            return true;
        }
        return false;
    }

   

}
