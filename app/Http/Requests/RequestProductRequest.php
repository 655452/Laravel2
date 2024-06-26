<?php

namespace App\Http\Requests;

use App\Rules\IniAmount;
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
            'name'         => 'required|string|max:255',
            'categories.*' => 'required',
            'unit_price'   => ['required', new IniAmount],
            'description'  => 'nullable|string|max:1000',
            'image'        => 'image|mimes:jpeg,png,jpg|max:5098',
        ];
    }

    public function attributes()
    {
        return [
            'name'  => trans('validation.attributes.name'),
            'image' => trans('validation.attributes.image'),
        ];
    }

}
