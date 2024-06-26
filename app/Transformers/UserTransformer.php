<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 10/24/2017
 * Time: 9:36 PM
 */

namespace App\Transformers;

class UserTransformer extends \Nahid\Presento\Transformer
{
    public function getUserIdProperty($value)
    {
        return md5($value);
    }
}
