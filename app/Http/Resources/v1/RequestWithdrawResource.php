<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestWithdrawResource extends JsonResource
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
            "user"                      => $this->user->name,
            'date_db_style'             => $this->date->format('Y-m-d H:i:s'),
            'date'                      => $this->date->format('d M Y'),
            'status'                    => $this->status,
            'status_label'              => trans('request_withdraw_statuses.' . $this->status),
            "amount"                    => number_format($this->amount,2),
        ];
    }
}
