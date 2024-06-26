<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 18/4/20
 * Time: 2:07 PM
 */

namespace App\Http\Resources\v1;


use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderResource extends ResourceCollection
{
    public function toArray( $request )
    {
        return [
            'status' => 200,
            'data'   => $this->collection
        ];
    }
}