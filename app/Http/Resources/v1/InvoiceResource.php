<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray( $request )
    {
        return [
            "meta"                      => $this->meta,
            "remarks"                   => $this->remarks,
            'payments'                  => TransactionResource::collection(
                $this->whenLoaded('transactions')
            )
        ];
    }
}
