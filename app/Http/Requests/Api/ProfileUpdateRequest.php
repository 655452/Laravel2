<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 2/5/20
 * Time: 8:44 PM
 */

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{

    protected $id;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     => ['required', 'string', 'max:120'],
            'email'    => [
                'required',
                'string',
                Rule::unique("users", "email")->ignore($this->id),
                'email',
                'max:100',
            ],
            'username' => request('username') ? [
                'required',
                'string',
                Rule::unique("users", "username")->ignore($this->id),
                'max:60',
            ] : ['nullable'],
            'phone'    => ['required', 'max:60'],
            'address'  => ['nullable', 'max:200'],
            'image'    => ['nullable'],
        ];
    }
}
