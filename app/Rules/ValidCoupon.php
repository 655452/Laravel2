<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Laravel\Cashier\Cashier;
use Stripe\Coupon as StripeCoupon;
use Stripe\Exception\InvalidRequestException;

class ValidCoupon implements Rule
{
    protected $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $coupon = StripeCoupon::retrieve($value, Cashier::stripeOptions());
            if (!$coupon->valid) {
                $this->message = 'coupon is invalid!';

                return false;
            }
            return true;
        } catch (InvalidRequestException $e) {
            $this->message = 'coupon does not exist!';

            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
