<?php

namespace App\Http\Requests;

use App\Libraries\FileLibrary;
use Illuminate\Foundation\Http\FormRequest;

class AddonRequest extends FormRequest
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
            'purchase_username'     => ['nullable', 'string', 'max:200'],
            'purchase_code'         => ['nullable', 'string', 'max:255'],
            'addon_file'             => 'required|file|mimes:zip|max:307200'
        ];
    }

//    public function withValidator($validator)
//    {
//        $validator->after(function ($validator) {
////            $addon_file_read = FileLibrary::read_json('addon.json', $this->file_extract_path . $this->file_folder_name);
//            $addons = Addon::where(['slug' => $addon_file_read->data->slug, 'version' => $addon_file_read->data->version])->get(), 'obj', 'slug');
//            //
//            //                    if (isset($addons[$obj->name]) && $addons[$obj->name]->version == $obj->version) {
//            //                        $this->form_validation->set_message("fileUpload", "This addon already installed.");
//            //                        return false;
//            //                    } else {
//            //
//            //                    }
//
//            if ($this->menuItemNameUniqueCheck()) {
//                $validator->errors()->add('name', 'The menu item name already exists.');
//            }
//            if ($this->priceValidationCheck()) {
//                $validator->errors()->add('discount_price', 'The discount price is greater than the unit price.');
//            }
//        });
//    }
}
