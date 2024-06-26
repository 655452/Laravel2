<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/14/20
 * Time: 3:19 PM
 */

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemVariationResource extends JsonResource
{
    public function toArray( $request )
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'unit_price'     => $this->price,
            "currency_code"     => setting('currency_code'),
            'discount_price' => $this->discount_price,
        ];
    }

}
