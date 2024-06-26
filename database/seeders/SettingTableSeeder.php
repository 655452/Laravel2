<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Setting as SeederSetting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingArray['site_name']                       = 'Food Bank';
        $settingArray['site_email']                      = 'info@food-bank.xyz';
        $settingArray['site_phone_number']               = '+8801777664555';
        $settingArray['site_logo']                       = 'seeder/settings/logo.png';
        $settingArray['fav_icon']                        = 'seeder/settings/favicon.png';
        $settingArray['site_address']                    = 'Dhaka';
        $settingArray['site_footer']                     = '@ All Rights Reserved';
        $settingArray['site_description']                = 'Organic & Tasty Food for your Table.';
        $settingArray['currency_name']                   = 'USD';
        $settingArray['currency_code']                   = '$';
        $settingArray['locale']                          = 'en';
        $settingArray['geolocation_distance_radius']     = 20;
        $settingArray['order_commission_percentage']     = 5;
        $settingArray['free_delivery_radius']            = 0;
        $settingArray['charge_per_kilo']                 = 5;
        $settingArray['basic_delivery_charge']           = 3;
        $settingArray['timezone']                        = 'Asia/Dhaka';
        $settingArray['frontend_theme']                  = 'default';
        $settingArray['twilio_auth_token']               = '';
        $settingArray['twilio_account_sid']              = '';
        $settingArray['twilio_from']                     = '';
        $settingArray['twilio_disabled']                 = 1;
        $settingArray['stripe_key']                      = 'pk_test_Kqmq6XXBwdoYJFLV1CSDnaxz';
        $settingArray['stripe_secret']                   = 'sk_test_JLeo9KvVZvhgsMzQ7KCl43in';
        $settingArray['razorpay_key']                    = 'rzp_test_eeBR6yhSmKHB65';
        $settingArray['razorpay_secret']                 = '3wdPy38X8rge55MDf8VDf9k0';
        $settingArray['paystack_public_key']             = 'pk_test_370ce5565f2a937efae6314df2dccba2781bfa69';
        $settingArray['paystack_secret_key']             = 'sk_test_e3c7763a083c0fa457da5f105b8bdbe75312235d';
        $settingArray['paypal_app_id']                   = 'sb-qzxs18789565@business.example.com';
        $settingArray['paypal_client_id']                = 'AbcV-BG5b30hjofcp2dj41GB1OYXE8_9-egRlV8z4R7vHiA-1mgL3Fvj3pkrOJyq0dC_vHNRAh_tp74p';
        $settingArray['paypal_client_secret']            = 'EP6r5hEtBc6icJeEseZIiOJqSRnFvqNLI7yxjplzITaObh-t-516gGJ_EysXisLtEavaIMcjrG9aYprz';
        $settingArray['paypal_mode']                     = 'sandbox';
        $settingArray['paytm_environment']               = 'sandbox';
        $settingArray['paytm_merchant_id']               = 'MhjqFc42556626519745';
        $settingArray['paytm_merchant_key']              = '0dC_Dq!nif6e1Kie';
        $settingArray['paytm_merchant_website']          = 'WEBSTAGING';
        $settingArray['paytm_channel']                   = 'WEB';
        $settingArray['paytm_industry_type']             = 'Retail';
        $settingArray['phonepe_merchant_id']             = 'PGTESTPAYUAT';
        $settingArray['phonepe_merchant_user_id']        = 'MUID123';
        $settingArray['phonepe_env']                     = 'sandbox';
        $settingArray['phonepe_salt_key']                = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $settingArray['phonepe_salt_index']              = '1';
        $settingArray['sslcommerz_store_name']           = 'testfoodkp1pi';
        $settingArray['sslcommerz_store_id']             = 'foodk6472ed754a400';
        $settingArray['sslcommerz_store_password']       = 'foodk6472ed754a400@ssl';
        $settingArray['sslcommerz_mode']                 = 'sandbox';
        $settingArray['mail_host']                       = '';
        $settingArray['mail_port']                       = '';
        $settingArray['mail_username']                   = '';
        $settingArray['mail_password']                   = '';
        $settingArray['order_attachment_checking']       = '5';
        $settingArray['delivery_boy_order_amount_limit'] = 10000;
        $settingArray['mail_from_name']                  = 'inilabs';
        $settingArray['mail_from_address']               = 'demo@food-bank.xyz';
        $settingArray['mail_disabled']                   = 1;
        $settingArray['fcm_secret_key']                  = 'AAAAiD42-oQ:APA91bHGPvVS90VfZQalKkMsD-7iYlsoNv8V3BOd2mjHvbxoQi6c1T6uCStbseK3ZBLpOzl3YFxiHn90fgf0w_66U6SA98232tCP2MDm0FR__sj_2Q6aie6ht5l78D5XCj4lT8z4v2JA';
        $settingArray['firebase_api_key']                = 'AIzaSyDefrY2CxjHICX2m9Z3HiPKWABp4HNheMQ';
        $settingArray['firebase_authDomain']             = 'foodbank-dc2a5.firebaseapp.com';
        $settingArray['projectId']                       = 'foodbank-dc2a5';
        $settingArray['storageBucket']                   = 'foodbank-dc2a5.appspot.com';
        $settingArray['messagingSenderId']               = '585159342724';
        $settingArray['appId']                           = '1:585159342724:web:1634134c98a3a6324be0d1';
        $settingArray['measurementId']                   = 'G-G5MWWTQNBX';
        $settingArray['facebook_key']                    = '2146804022138583';
        $settingArray['facebook_secret']                 = 'd0fbfc2866a05acca95f091c547a94f3';
        $settingArray['facebook_url']                    = 'https://demo.food-bank.xyz/auth/facebook/callback';
        $settingArray['google_map_api_key']              = 'AIzaSyBvRR2Xoh_6-RY8-6WkU4JE9M9zg1LaL-I';
        $settingArray['google_key']                      = '86610761817-238dkiq3fnutpugklq5mtthan6gc0qo2.apps.googleusercontent.com';
        $settingArray['google_secret']                   = 'AIzaSyCELoLWlmIo6Sm2mwTB1lQ3P1_p31B2zkg';
        $settingArray['google_url']                      = 'https://demo.food-bank.xyz/auth/google/callback';
        $settingArray['otp_type_checking']               = 'email';
        $settingArray['otp_digit_limit']                 = 6;
        $settingArray['otp_expire_time']                 = 10;
        $settingArray['license_code']                    = session()->has('license_code') ? session()->get('license_code') : "";
        $settingArray['settingtypesocial']               = 'facebook';
        $settingArray['facebook']                        = 'https://www.facebook.com/inilabs';
        $settingArray['instagram']                       = 'https://www.instagram.com/inilabs';
        $settingArray['youtube']                         = 'https://www.youtube.com/inilabs';
        $settingArray['twitter']                         = 'https://twitter.com/inilabs';
        $settingArray['billing-type']                    = 10;
        $settingArray['support_phone']                   = '+9901555555';
        $settingArray['customer_app_name']               = 'Customer';
        $settingArray['customer_app_logo']               = 'seeder/settings/logo.png';
        $settingArray['customer_splash_screen_logo']     = 'seeder/settings/logo.png';
        $settingArray['vendor_app_name']                 = 'Vendor';
        $settingArray['vendor_app_logo']                 = 'seeder/settings/logo.png';
        $settingArray['vendor_splash_screen_logo']       = 'seeder/settings/logo.png';
        $settingArray['delivery_app_name']               = 'Delivery';
        $settingArray['delivery_app_logo']               = 'seeder/settings/logo.png';
        $settingArray['delivery_splash_screen_logo']     = 'seeder/settings/logo.png';
        $settingArray['banner_title']                    = 'Organic & Tasty Food for your Table.';
        $settingArray['banner_image']                    = 'seeder/settings/hero.png';
        $settingArray['app_mockup']                      = 'seeder/settings/mockup.png';
        $settingArray['ios_app_link']                    = 'https://play.google.com/store/apps/details?id=com.inilabs.foodbank';
        $settingArray['android_app_link']                = 'https://play.google.com/store/apps/details?id=com.inilabs.foodbank';

        SeederSetting::set($settingArray);
        SeederSetting::save();
    }
}
