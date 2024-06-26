<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestProductRequest extends FormRequest
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
            'categories.*' => 'required',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'mrp'          => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'name'  => trans('validation.attributes.name'),
            'image' => trans('validation.attributes.image'),
            'mrp'   => trans('validation.attributes.mrp'),
        ];
    }

}
