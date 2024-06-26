<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:60'],
            'last_name'  => ['required', 'string', 'max:60'],
            'email'      => ['required', 'string', Rule::unique("users", "email")->ignore($this->customer), 'email', 'max:100'],
            'username'   => request('username') ? ['required', 'string', Rule::unique("users", "username")->ignore($this->customer), 'max:60'] : ['nullable'],
            'password'   => [$this->customer ? 'nullable' : 'required'],
            'phone'      => ['required', 'max:60'],
            'status'     => ['required', 'numeric'],
            'address'    => ['nullable', 'max:200'],
            'image'      => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
        ];
    }

}
