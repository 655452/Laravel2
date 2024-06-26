<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 19/4/20
 * Time: 2:28 PM
 */

namespace App\Enums;
interface RequestWithdrawStatus
{
    const PENDING  = 5;
    const ACCEPT   = 10;
    const DECLINE  = 15;
    const COMPLETED = 20;
}
