<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopProductRequest extends FormRequest
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
            'product_id' => ['required', 'numeric'],
            'unit_price' => ['required', 'numeric', 'digits_between: 1,10'],
            'quantity'   => ['required', 'numeric|min:1|max:5'],
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => trans('validation.attributes.product_id'),
            'unit_price' => trans('validation.attributes.unit_price'),
            'quantity'   => trans('validation.attributes.quantity'),
        ];
    }
}
