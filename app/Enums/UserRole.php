<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 17/4/20
 * Time: 12:47 PM
 */

namespace App\Enums;

interface UserRole
{
    const ADMIN           = 1;
    const CUSTOMER        = 2;
    const RESTAURANTOWNER = 3;
    const DELIVERYBOY     = 4;
    const WAITER          = 5;
}
