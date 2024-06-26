<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RatingsRequest extends FormRequest
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
            'rating'     => 'required|numeric|min:1|max:5',
            'review'     => 'required|string|max:500',
            'restaurant_id'    => 'required|numeric',
            'status'     => 'required|numeric',
        ];
    }
}
