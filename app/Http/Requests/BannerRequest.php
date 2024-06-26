<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
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
            'name'          => ['nullable', 'string', 'max:200'],
            'restaurant_id' => ['required', 'numeric'],
            'description'   => ['nullable', 'string', 'max:255'],
            'url'           => ['nullable', 'string'],
            'status'        => ['required', 'numeric'],
            'image'         => $this->banner ? 'image|mimes:jpeg,png,jpg|max:3072' : 'required|image|mimes:jpeg,png,jpg|max:3072',
        ];
    }

    public function attributes()
    {
        return [
            'name'        => trans('validation.attributes.name'),
            'image'       => trans('validation.attributes.image'),
            'description' => trans('validation.attributes.description'),
            'url'         => trans('validation.attributes.url'),
            'sort_order'  => trans('validation.attributes.sort_order'),
            'status'      => trans('validation.attributes.status'),
        ];
    }
}
