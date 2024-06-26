<?php

use App\Models\Setting;
// Updates folder
$product = 'food-bank';

// Envato id
$envato_item_id = 35543239;

// Product Url from codecanyon
$productUrl = 'https://codecanyon.net/item/foodbank-all-in-one-multi-restaurant-food-ordering-management-system/35543239';

$updatesDomain = 'https://auto-update.inilabs.xyz/version-log';

$verifyDomain = 'https://codecanyon.net/user/inilabs';

return [

    /*
     * Model name of where purchase code is stored
     */
    'setting' => Setting::class,

    /*
     * Add redirect route here route('login') will be used
     */
    'redirectRoute' => 'login',

    'envato_item_id' => $envato_item_id,

    'envato_product_name' => $product,

    'envato_product_url' => $productUrl,

    /*
    * Temp folder to store update before to install it.
    */
    'tmp_path' => storage_path() . '/app',
    /*
    * URL where your updates are stored ( e.g. for a folder named 'updates', under http://site.com/yourapp ).
    */
    'update_baseurl' => 'https://auto-update.inilabs.xyz/updatefile/food-bank',
    /*
    * URL to verify your purchase code
    */
    'verify_url' => $verifyDomain . '/verify-purchase',

    /*
     *
     */
    'updater_file_path' => $updatesDomain . '/' . $product . '/update-version.json',

    /*
    * Set a middleware for the route: updater.update
    * Only 'auth' NOT works (manage security using 'allow_users_id' configuration)
    */
    'middleware' => ['web', 'auth'],

    /*
    * Set which users can perform an update;
    * This parameter accepts: ARRAY(user_id) ,or FALSE => for example: [1]  OR  [1,3,0]  OR  false
    * Generally, ADMIN have user_id=1; set FALSE to disable this check (not recommended)
    */

    'allow_users_id' => true,

    'versionLog' => 'https://auto-update.inilabs.xyz/version-log/'.$product.'/all-version.json',
    'versionLogs' => 'https://auto-update.inilabs.xyz/version-log/'.$product,

];
