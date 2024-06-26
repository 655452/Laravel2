<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class FooterMenuSection extends BaseModel
{
    protected $table       = 'footer_menu_sections';
    protected $fillable    = ['name'];
}
