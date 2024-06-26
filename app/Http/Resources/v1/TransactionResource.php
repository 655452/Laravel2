<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "id"                        => $this->id,
            "type"                      => $this->type,
            "from_user"                 => $this->from_user,
            "to_user"                   => $this->to_user,
            "amount"                    => $this->amount,
            "status"                    => trans('transaction_status.' . $this->status),
            'date'                      => $this->date,
        ];
    }
}
