<?php

namespace App\Http\Requests\Api;

use App\Models\Table;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255'],
            'capacity'      => ['required', 'numeric', 'min:0'],
            'status'        => ['required', 'numeric'],
            'restaurant_id' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'name'          => trans('validation.attributes.name'),
            'capacity'      => trans('validation.attributes.capacity'),
            'restaurant_id' => trans('validation.attributes.restaurant'),
            'status'        => trans('validation.attributes.status'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->categoryNameUniqueCheck()) {
                $validator->errors()->add('name', 'The table  name already exists.');
            }

        });
    }

    private function categoryNameUniqueCheck()
    {
        $id            = $this->table;
        $queryArray['name']          = request('name');
        $queryArray['restaurant_id'] = request('restaurant_id');

        $tables = Table::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($tables)) {
            return false;
        }
        return true;
    }
}
