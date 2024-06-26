<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'restaurant_id'     => ['required','numeric'],
            'name'              => ['required', 'string','max:60'],
            'email'             => ['required', 'string','max:60'],
            'phone'             => ['required', 'string','max:60'],
            'reservation_date'  =>'required|date|after_or_equal:today',
            'guest'             => ['required', 'numeric'],
            'time_slot'         => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'name'        => trans('validation.attributes.first_name'),
            'email'             => trans('validation.attributes.email'),
            'phone'             => trans('validation.attributes.phone'),
        ];
    }
}
