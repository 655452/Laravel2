<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 18/4/20
 * Time: 12:33 PM
 */

namespace App\Enums;

interface OrderStatus
{
    const PENDING    = 5;
    const CANCEL     = 10;
    const REJECT     = 12;
    const ACCEPT     = 14;
    const PROCESS    = 15;
    const ON_THE_WAY = 17;
    const COMPLETED  = 20;
}
