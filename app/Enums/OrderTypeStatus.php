<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 18/4/20
 * Time: 12:33 PM
 */

namespace App\Enums;

interface OrderTypeStatus
{
    const DELIVERY   = 1;
    const PICKUP     = 2;
    const TABLE      = 3;
}
