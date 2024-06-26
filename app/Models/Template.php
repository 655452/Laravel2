<?php

namespace App\Models;

use App\Models\BaseModel;

class Template extends BaseModel
{
    protected $table       = 'templates';
    protected $fillable    = ['name'];
    protected $auditColumn       = true;
}
