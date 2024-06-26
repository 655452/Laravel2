<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 20/4/20
 * Time: 2:47 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia; 

class Setting extends Model
{

    protected $table = 'settings';

}
