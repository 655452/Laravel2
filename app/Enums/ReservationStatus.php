<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 19/4/20
 * Time: 2:29 PM
 */

namespace App\Enums;


interface ReservationStatus
{
    const PENDING = 1;
    const ACCEPT  = 2;
    const CANCEL  = 3;
    const REJECT  = 4;
}
