<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
      return [
           'site_email'                    => $this['site_email'],
           'site_name'                     => $this['site_name'],
           'site_phone_number'             => $this['site_phone_number'],
           'stripe_key'                    => $this['stripe_key'],
           'stripe_secret'                 => $this['stripe_secret'],
           'paystack_key'                  => $this['paystack_key'],
           'razorpay_key'                  => $this['razorpay_key'],
           'razorpay_secret'               => $this['razorpay_secret'],
           'google_map_api_key'            => $this['google_map_api_key'],
           'free_delivery_radius'          => $this['free_delivery_radius'],
           'charge_per_kilo'               => $this['charge_per_kilo'],
           'basic_delivery_charge'         => $this['basic_delivery_charge'],
           'currency_name'                 => $this['currency_name'],
           'support_phone'                 => $this['support_phone'],
           'currency_code'                 => $this['currency_code'],
           'site_logo'                     => asset("images/app/" . setting('site_logo')),
           'customer_app_name'             => $this['customer_app_name'],
           'customer_app_logo'             => asset("images/app/" . setting('customer_app_logo')),
           'customer_splash_screen_logo'   => asset("images/app/" . setting('customer_splash_screen_logo')),
           'vendor_app_name'             => $this['vendor_app_name'],
           'vendor_app_logo'             => asset("images/app/" . setting('vendor_app_logo')),
           'vendor_splash_screen_logo'   => asset("images/app/" . setting('vendor_splash_screen_logo')),
           'delivery_app_name'             => $this['delivery_app_name'],
           'delivery_app_logo'             => asset("images/app/" . setting('delivery_app_logo')),
           'delivery_splash_screen_logo'   => asset("images/app/" . setting('delivery_splash_screen_logo')),
       ];
    }
}
