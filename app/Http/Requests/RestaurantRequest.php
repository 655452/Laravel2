<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestaurantRequest extends FormRequest
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
        if ($this->restaurant) {
            $userID = $this->restaurant->user->id;

            $email    = ['required', 'email', 'string', Rule::unique("users", "email")->ignore($userID)];
            $username = ['required', 'string', Rule::unique("users", "username")->ignore($userID)];
            $password = ['nullable'];
        } else {
            $email    = ['required', 'email', 'string', 'unique:users,email'];
            $username = ['required', 'string', 'unique:users,username'];
            $password = ['required', 'min:6'];
        }

        return [
            'name'              => ['required', 'string', Rule::unique("restaurants", "name")->ignore($this->restaurant), 'max:191'],
            'description'       => ['nullable', 'string'],
            'cuisines.*'        => 'nullable',
            'lat'               => ['required'],
            'long'              => ['required'],
            'opening_time'      => ['nullable'],
            'closing_time'      => ['nullable'],
            'restaurantaddress' => ['required', 'max:200'],
            'current_status'    => ['required', 'numeric'],
            'delivery_status'   => ['required', 'numeric'],
            'pickup_status'     => ['required', 'numeric'],
            'table_status'      => ['required', 'numeric'],
            'status'            => ['required', 'numeric'],
            'first_name'        => ['required', 'string'],
            'last_name'         => ['required', 'string'],
            'email'             => $email,
            'password'          => $password,
            'image'             => 'image|mimes:jpeg,png,jpg|max:5098',
            'restaurant_logo'   => 'image|mimes:jpeg,png,jpg|max:5098',
            'username'          => request('username') ? $username : ['nullable'],
            'phone'             => ['required', 'numeric'],
            'address'           => ['required', 'max:200'],
            'userstatus'        => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'name'              => trans('validation.attributes.name'),
            'description'       => trans('validation.attributes.description'),
            'lat'               => trans('validation.attributes.lat'),
            'long'              => trans('validation.attributes.long'),
            'opening_time'      => trans('validation.attributes.opening_time'),
            'closing_time'      => trans('validation.attributes.closing_time'),
            'restaurantaddress' => trans('validation.attributes.address'),
            'current_status'    => trans('validation.attributes.current_status'),
            'status'            => trans('validation.attributes.status'),
            'first_name'        => trans('validation.attributes.first_name'),
            'last_name'         => trans('validation.attributes.last_name'),
            'email'             => trans('validation.attributes.email'),
            'username'          => trans('validation.attributes.username'),
            'phone'             => trans('validation.attributes.phone'),
            'address'           => trans('validation.attributes.address'),
            'cuisines'          => trans('validation.attributes.cuisines'),
            'image'             => trans('validation.attributes.image'),
            'restaurant_logo'   => trans('validation.attributes.restaurant_logo'),
        ];
    }
}
