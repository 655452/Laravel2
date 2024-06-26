<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestaurantOwnerRequest extends FormRequest
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
        $userID = $this->restaurant_owner;
        if ($userID) {
            $email    = ['required', 'email', 'string', Rule::unique("users", "email")->ignore($userID)];
            $username = ['required', 'string', Rule::unique("users", "username")->ignore($userID)];
            $password = ['nullable'];
        } else {
            $email    = ['required', 'email', 'string', 'unique:users,email'];
            $username = ['required', 'string', 'unique:users,username'];
            $password = ['required', 'min:6'];
        }

        return [
            'first_name' => ['required', 'string'],
            'last_name'  => ['required', 'string'],
            'email'      => $email,
            'password'   => $password,
            'image'      => 'image|mimes:jpeg,png,jpg|max:4096',
            'username'   => request('username') ? $username : ['nullable'],
            'phone'      => ['required', 'max:40'],
            'address'    => ['required', 'max:200'],
            'status'     => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => trans('validation.attributes.first_name'),
            'last_name'  => trans('validation.attributes.last_name'),
            'email'      => trans('validation.attributes.email'),
            'image'      => trans('validation.attributes.image'),
            'username'   => trans('validation.attributes.username'),
            'phone'      => trans('validation.attributes.phone'),
            'address'    => trans('validation.attributes.address'),
            'status'     => trans('validation.attributes.status'),
        ];
    }
}
