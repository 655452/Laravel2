<?php

namespace App\Helpers;

class Support
{
    public static function checking()
    {
        $postData = array(
            'purchase_code' => setting('web_purchase_code'),
            'username'      => setting('web_purchase_username'),
            'itemId'        => config('installer.itemId'),
            'ip'            => Ip::get(),
            'domain'        => getDomain(),
            'purpose'       => 'install',
            "sql"           => false,
            'product_name'  => config('installer.item_name'),
            'version'       => config('installer.item_version')
        );


        try {
            $apiUrl = config('installer.purchaseCodeCheckerUrl');
            $data = Curl::request($apiUrl, $postData);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return $data;

    }
}
