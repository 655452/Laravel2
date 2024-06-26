<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationBookRequest extends FormRequest
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
            'reservation_date'  =>'required|date|after_or_equal:today',
            'qtyInput'          => ['required', 'numeric'],
            'time_slot'         => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'time_slot'        => 'Time-Slot ',
            'qtyInput'         => 'Guest',
            'reservation_date'  => 'Date',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->timeSlotValidationCheck()) {
                $validator->errors()->add('time_slot', 'The Time-Slot Not Available.');
            }
        });
    }
    private function timeSlotValidationCheck()
    {
        if (request('time_slot') ==0) {
            return true;
        }
        return false;
    }
}
