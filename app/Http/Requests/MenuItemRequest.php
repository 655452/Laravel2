<?php

namespace App\Http\Requests;

use App\Models\MenuItem;
use App\Rules\IniAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuItemRequest extends FormRequest
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
            'restaurant_id'  => ['required', 'numeric'],
            'name'           => ['required', 'string', 'max:255'],
            'categories.*'   => 'nullable',
            'unit_price'     => ['required', 'numeric', new IniAmount()],
            'discount_price' => ['nullable', 'numeric', new IniAmount()],
            'status'         => 'required|numeric',
            'description'    => 'nullable|string|max:1000',
            // 'image'          => 'image|mimes:jpeg,png,jpg|max:4096',
            // 'image'         => 'image|mimes:jpeg,jpg,png,mp4,mov,avi|max:10240'
            'image.*' => 'image|mimes:jpeg,jpg,png,mp4,mp3,mov,avi|max:10485760',
        ];
    }

    public function attributes()
    {
        return [
            'name'   => trans('validation.attributes.name'),
            'image'  => trans('validation.attributes.image'),
            'status' => trans('validation.attributes.status'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->menuItemNameUniqueCheck()) {
                $validator->errors()->add('name', 'The menu item name already exists.');
            }
            if ($this->priceValidationCheck()) {
                $validator->errors()->add('discount_price', 'The discount price is greater than the unit price.');
            }
        });
    }

    private function menuItemNameUniqueCheck()
    {
        $restaurant_id = auth()->user()->restaurant->id ?? 0;
        $id            = $this->menu_item;

        $queryArray['name']          = request('name');
        $queryArray['restaurant_id'] = $restaurant_id;

        $menu_items = MenuItem::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($menu_items)) {
            return false;
        }
        return true;
    }

    private function priceValidationCheck()
    {
        if (request('unit_price') < request('discount_price')) {
            return true;
        }
        return false;
    }

}
