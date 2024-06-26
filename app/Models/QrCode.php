<?php

namespace App\Models;

class QrCode extends BaseModel
{
    protected $table       = 'qr_codes';
    protected $auditColumn       = true;
    protected $fillable    = ['shop_id', 'style', 'eye_style', 'color', 'background_color', 'mode', 'qrcode_text', 'qrcode_logo'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }


}
