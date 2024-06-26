<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 18/4/20
 * Time: 8:59 PM
 */

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopOrderRequest extends FormRequest
{
    protected $id;
    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

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
        if ($this->id) {
            return [
                'items'           => ['json'],
                'delivery_charge' => ['numeric'],
                'mobile'          => ['regex:/^([0-9\s\-\+\(\)]*)$/'],
                'address'         => ['string'],
            ];
        } else {
            return [
                'name'            => ['required'],
                'phone'           => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                'email'           => ['nullable', 'email', 'max:100'],
                'items'           => ['required', 'json'],
                'delivery_charge' => ['required', 'numeric'],
                'mobile'          => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                'address'         => ['required', 'string'],
                'lat'             => ['required'],
                'long'            => ['required'],
                'total'           => ['required'],
            ];
        }

    }
}
