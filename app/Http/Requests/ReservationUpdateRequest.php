<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationUpdateRequest extends FormRequest
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
            'first_name'        => ['required', 'string','max:60'],
            'last_name'         => ['required', 'string','max:60'],
            'email'             => ['required', 'string','max:60'],
            'phone'             => ['required', 'string','max:60'],
            'reservation_date'  => ['required'],
            'guest'             => ['required', 'numeric'],
            'time_slot'         => ['required', 'numeric'],
            'user_id'           => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'first_name'        => trans('validation.attributes.first_name'),
            'last_name'         => trans('validation.attributes.last_name'),
            'email'             => trans('validation.attributes.email'),
            'phone'             => trans('validation.attributes.phone'),
        ];
    }
}
