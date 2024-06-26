<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
            'title'                  => ['required', 'string', 'max:150'],
            'description'            => ['required', 'string'],
            'footer_menu_section_id' => ['required', 'numeric'],
            'template_id'            => ['required', 'numeric'],
            'status'                 => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'title'                  => trans('validation.attributes.title'),
            'description'            => trans('validation.attributes.description'),
            'footer_menu_section_id' => trans('validation.attributes.footer_menu_section_id'),
            'template_id'            => trans('validation.attributes.template'),
        ];
    }
}
