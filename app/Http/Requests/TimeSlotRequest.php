<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TimeSlotRequest extends FormRequest
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
            'restaurant_id'    => 'required|numeric',
            'start_time'    => 'required',
            'end_time'      => 'required',
            'status'        => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'start_time'    => trans('validation.attributes.start_time'),
            'end_time'      => trans('validation.attributes.end_time'),
            'status'        => trans('validation.attributes.status'),
        ];
    }

}
