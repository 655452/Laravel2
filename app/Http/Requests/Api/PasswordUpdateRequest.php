<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 2/5/20
 * Time: 9:57 PM
 */

namespace App\Http\Requests\Api;




use Illuminate\Support\Facades\Request;

class PasswordUpdateRequest extends Request
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
            'password_current'      => ['required', new CurrentPassword()],
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ];
    }
}