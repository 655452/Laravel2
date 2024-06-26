<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CuisineRequest extends FormRequest
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
        $retArray = [
            'name'        => ['required', 'string', Rule::unique("cuisines", "name")->ignore($this->cuisine), 'max:200'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'numeric'],
            'image'       => 'image|mimes:jpeg,png,jpg|max:2048',
        ];

        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID > 1) {
            unset($retArray['status']);
        }
        return $retArray;
    }

    public function attributes()
    {
        return [
            'name'        => trans('validation.attributes.name'),
            'image'       => trans('validation.attributes.image'),
            'description' => trans('validation.attributes.description'),
            'status'      => trans('validation.attributes.status'),
        ];
    }

}
