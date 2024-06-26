<?php

namespace App\Http\Controllers\Admin;

use Setting;
use App\Enums\Status;
use App\Helpers\Support;
use App\Models\Language;
use App\Libraries\MyString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;


class SettingController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Settings';
        $this->middleware(['permission:setting']);
        $this->middleware('license-activate');

    }

    // Site Setting
    public function index()
    {
        $this->data['language'] = Language::where('status', Status::ACTIVE)->get();
        return view('admin.setting.site', $this->data);
    }

    public function siteSettingUpdate(Request $request)
    {

        if (env('DEMO_MODE')) {
            return back()->withError('The site setting is disable for the demo');
        }

        $niceNames    = [];
        $settingArray = $this->validate($request, $this->siteValidateArray(), [], $niceNames);

        if ($request->hasFile('site_logo')) {
            $pre_site_logo = setting('site_logo');
            if (File::exists(public_path('images/' . $pre_site_logo))) {
                File::delete(public_path('images/' . $pre_site_logo));
            }

            $site_logo                 = request('site_logo');
            $originalName = $site_logo->getClientOriginalName();
            $settingArray['site_logo'] = time() . '_' .$originalName;
            $uniqueName =  $settingArray['site_logo'];
            $request->site_logo->move(public_path('images/'), $uniqueName);
        } else {
            unset($settingArray['site_logo']);
        }

        if ($request->hasFile('fav_icon')) {
            $pre_fav_icon = setting('fav_icon');
            if (File::exists(public_path('images/' . $pre_fav_icon))) {
                File::delete(public_path('images/' . $pre_fav_icon));
            }
            $fav_icon                 = request('fav_icon');
            $originalName = $fav_icon->getClientOriginalName();
            $settingArray['fav_icon'] = time() . '_' .$originalName;
            $uniqueName =  $settingArray['fav_icon'];
            $request->fav_icon->move(public_path('images'), $uniqueName);
        } else {
            unset($settingArray['fav_icon']);
        }
        if ($request->hasFile('banner_image')) {
            $pre_banner_image = setting('banner_image');
            if (File::exists(public_path('images/' . $pre_banner_image))) {
                File::delete(public_path('images/' . $pre_banner_image));
            }
            $banner_image                 = request('banner_image');
            $originalName = $banner_image->getClientOriginalName();
            $settingArray['banner_image'] = time() . '_' .$originalName;
            $uniqueName =  $settingArray['banner_image'];
            $request->banner_image->move(public_path('images'), $uniqueName);
        } else {
            unset($settingArray['banner_image']);
        }

        if ($request->hasFile('app_mockup')) {
            $pre_app_mockup = setting('app_mockup');
            if (File::exists(public_path('images/' . $pre_app_mockup))) {
                File::delete(public_path('images/' . $pre_app_mockup));
            }
            $app_mockup                 = request('app_mockup');
            $originalName = $app_mockup->getClientOriginalName();
            $settingArray['app_mockup'] = time() . '_' .$originalName;
            $uniqueName =  $settingArray['app_mockup'];
            $request->app_mockup->move(public_path('images'), $uniqueName);
        } else {
            unset($settingArray['app_mockup']);
        }

        if (isset($settingArray['timezone'])) {
            MyString::setEnv('APP_TIMEZONE', $settingArray['timezone']);
            Artisan::call('optimize:clear');
        }

        if (isset($settingArray['locale'])) {
            Session::put('applocale', $settingArray['locale']);
        }

        Setting::set($settingArray);
        Setting::save();

        return redirect(route('admin.setting.index'))->withSuccess('The Site setting updated successfully');
    }

    // SMS Setting
    public function smsSetting()
    {
        return view('admin.setting.sms', $this->data);
    }

    public function smsSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->smsValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.sms'))->withSuccess('The SMS setting updated successfully.');
    }


    // App Setting
    public function appSetting()
    {
        return view('admin.setting.app-setting', $this->data);
    }

    public function appSettingUpdate(Request $request)
    {
        if (env('DEMO_MODE')) {
            return back()->withError('The app setting is disable for the demo');
        }

        $niceNames    = [];
        $settingArray = $this->validate($request, $this->appValidateArray(), [], $niceNames);

        //customer app images
        if ($request->hasFile('customer_app_logo')) {
            $pre_customer_app_logo = setting('customer_app_logo');
            if (File::exists(public_path('images/app/' . $pre_customer_app_logo))) {
                File::delete(public_path('images/app/' . $pre_customer_app_logo));
            }
            $customer_app_logo                 = request('customer_app_logo');
            $originalName = $customer_app_logo->getClientOriginalName();
            $settingArray['customer_app_logo'] = time() . '_' .$originalName;
            $uniqueName =  $settingArray['customer_app_logo'];
            $request->customer_app_logo->move(public_path('images/app/'), $uniqueName);
        } else {
            unset($settingArray['customer_app_logo']);
        }

        if ($request->hasFile('customer_splash_screen_logo')) {
            $pre_customer_splash_screen_logo = setting('customer_splash_screen_logo');
            if (File::exists(public_path('images/app/' . $pre_customer_splash_screen_logo))) {
                File::delete(public_path('images/app/' . $pre_customer_splash_screen_logo));
            }
            $customer_splash_screen_logo                 = request('customer_splash_screen_logo');
            $originalName  = $customer_splash_screen_logo->getClientOriginalName();
            $settingArray['customer_splash_screen_logo'] = time() . '_' .$originalName;
            $uniqueName = $settingArray['customer_splash_screen_logo'];
            $request->customer_splash_screen_logo->move(public_path('images/app/'), $uniqueName);
        } else {
            unset($settingArray['customer_splash_screen_logo']);
        }

        //vendor app images
        if ($request->hasFile('vendor_app_logo')) {
            $pre_vendor_app_logo = setting('vendor_app_logo');
            if (File::exists(public_path('images/app/' . $pre_vendor_app_logo))) {
                File::delete(public_path('images/app/' . $pre_vendor_app_logo));
            }
            $vendor_app_logo                 = request('vendor_app_logo');
            $originalName  = $vendor_app_logo->getClientOriginalName();
            $settingArray['vendor_app_logo'] = time() . '_' .$originalName;
            $uniqueName = $settingArray['vendor_app_logo'] ;
            $request->vendor_app_logo->move(public_path('images/app/'), $uniqueName);
        } else {
            unset($settingArray['vendor_app_logo']);
        }

        if ($request->hasFile('vendor_splash_screen_logo')) {
            $pre_vendor_splash_screen_logo = setting('vendor_splash_screen_logo');
            if (File::exists(public_path('images/app/' . $pre_vendor_splash_screen_logo))) {
                File::delete(public_path('images/app/' . $pre_vendor_splash_screen_logo));
            }
            $vendor_splash_screen_logo                 = request('vendor_splash_screen_logo');
            $originalName  =  $vendor_splash_screen_logo->getClientOriginalName();
            $settingArray['vendor_splash_screen_logo'] = time() . '_' .$originalName;
            $uniqueName = $settingArray['vendor_splash_screen_logo'] ;
            $request->vendor_splash_screen_logo->move(public_path('images/app/'), $uniqueName);
        } else {
            unset($settingArray['vendor_splash_screen_logo']);
        }

        //delivery app images
        if ($request->hasFile('delivery_app_logo')) {
            $pre_delivery_app_logo = setting('delivery_app_logo');
            if (File::exists(public_path('images/app/' . $pre_delivery_app_logo))) {
                File::delete(public_path('images/app/' . $pre_delivery_app_logo));
            }
            $delivery_app_logo                 = request('delivery_app_logo');
            $originalName  = $delivery_app_logo->getClientOriginalName();
            $settingArray['delivery_app_logo'] = time() . '_' .$originalName;
            $uniqueName =  $settingArray['delivery_app_logo'] ;
            $request->delivery_app_logo->move(public_path('images/app/'), $uniqueName);
        } else {
            unset($settingArray['delivery_app_logo']);
        }

        if ($request->hasFile('delivery_splash_screen_logo')) {

            $pre_delivery_splash_screen_logo = setting('delivery_splash_screen_logo');
            if (File::exists(public_path('images/app/' . $pre_delivery_splash_screen_logo))) {
                File::delete(public_path('images/app/' . $pre_delivery_splash_screen_logo));
            }
            $delivery_splash_screen_logo                 = request('delivery_splash_screen_logo');
            $originalName = $delivery_splash_screen_logo->getClientOriginalName();
            $settingArray['delivery_splash_screen_logo'] = time() . '_' .$originalName;
            $uniqueName = $settingArray['delivery_splash_screen_logo'] ;
            $request->delivery_splash_screen_logo->move(public_path('images/app/'),  $uniqueName);
        } else {
            unset($settingArray['delivery_splash_screen_logo']);
        }

        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.app'))->withSuccess('The App setting updated successfully.');
    }

    // Support Setting
    public function supportSetting()
    {
        return view('admin.setting.support-setting', $this->data);
    }

    public function supportSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->supportValidateArray(), [], $niceNames);
        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.support'))->withSuccess('The support setting updated successfully.');
    }

    // Payment Setting
    public function paymentSetting()
    {
        return view('admin.setting.payment', $this->data);
    }

    public function paymentSettingUpdate(Request $request)
    {
        if ($request->settingtypepayment == 'stripe') {
            $this->stripeSetting($request);
        }else if ($request->settingtypepayment == 'paytm') {
            $this->paytmSetting($request);
        }else if ($request->settingtypepayment == 'phonepe') {
            $this->phonepeSetting($request);
        }else if ($request->settingtypepayment == 'sslcommerz') {
            $this->sslcommerzSetting($request);
        } else if ($request->settingtypepayment == 'razorpay') {
            $this->razorpaySetting($request);
        }  else if ($request->settingtypepayment == 'paystack') {
            $this->paystackSetting($request);
        } else if ($request->settingtypepayment == 'paypal') {
            $this->paypalSetting($request);
        } else {
            return redirect(route('admin.setting.payment'));
        }
        return redirect(route('admin.setting.payment'))->withSuccess('The Payment setting updated successfully.');
    }

    private function sslcommerzSetting($request){
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->sslcommerzValidateArray(), [], $niceNames);

        MyString::setEnv('SSLCOMMERZ_STORE_NAME', $settingArray['sslcommerz_store_name']);
        MyString::setEnv('SSLCOMMERZ_STORE_ID', $settingArray['sslcommerz_store_id']);
        MyString::setEnv('SSLCOMMERZ_STORE_PASSWORD', $settingArray['sslcommerz_store_password']);
        MyString::setEnv('SSLCOMMERZ_MODE', $settingArray['sslcommerz_mode']);

        Setting::set($settingArray);
        Setting::save();
    }

    private function phonepeSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->phonePeValidateArray(), [], $niceNames);

        MyString::setEnv('PHONEPE_MERCHANT_ID', $settingArray['phonepe_merchant_id']);
        MyString::setEnv('PHONEPE_MERCHANT_USER_ID', $settingArray['phonepe_merchant_user_id']);
        MyString::setEnv('PHONEPE_ENV', $settingArray['phonepe_env']);
        MyString::setEnv('PHONEPE_SALT_KEY', $settingArray['phonepe_salt_key']);
        MyString::setEnv('PHONEPE_SALT_INDEX', $settingArray['phonepe_salt_index']);

        Setting::set($settingArray);
        Setting::save();
    }


    private function paytmSetting($request){
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->paytmValidateArray(), [], $niceNames);

        MyString::setEnv('PAYTM_ENVIRONMENT', $settingArray['paytm_environment']);
        MyString::setEnv('PAYTM_MERCHANT_ID', $settingArray['paytm_merchant_id']);
        MyString::setEnv('PAYTM_MERCHANT_KEY', $settingArray['paytm_merchant_key']);
        MyString::setEnv('PAYTM_MERCHANT_WEBSITE', $settingArray['paytm_merchant_website']);
        MyString::setEnv('PAYTM_CHANNEL', $settingArray['paytm_channel']);
        MyString::setEnv('PAYTM_INDUSTRY_TYPE', $settingArray['paytm_industry_type']);

        Setting::set($settingArray);
        Setting::save();
    }


    private function stripeSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->stripeValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();
    }

    private function razorpaySetting($request) {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->razorpayValidateArray(), [], $niceNames);
        MyString::setEnv('RAZORPAY_KEY', $settingArray['razorpay_key']);
        MyString::setEnv('RAZORPAY_SECRET', $settingArray['razorpay_secret']);

        Setting::set($settingArray);
        Setting::save();
    }

    private function paystackSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->paystackValidateArray(), [], $niceNames);

        MyString::setEnv('PAYSTACK_PUBLIC_KEY', $settingArray['paystack_key']);
        MyString::setEnv('PAYSTACK_SECRET_KEY', $settingArray['paystack_secret']);
        MyString::setEnv('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co');

        Setting::set($settingArray);
        Setting::save();
    }

    private function paypalSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->paypalValidateArray(), [], $niceNames);
        MyString::setEnv('PAYPAL_CLIENT_ID', $settingArray['paypal_client_id']);
        MyString::setEnv('PAYPAL_CLIENT_SECRET', $settingArray['paypal_client_secret']);
        MyString::setEnv('PAYPAL_MODE', $settingArray['paypal_mode']);
        MyString::setEnv('PAYPAL_APP_ID', $settingArray['paypal_app_id']);
        Artisan::call('optimize:clear');
        Setting::set($settingArray);
        Setting::save();
    }

    // EMail Setting
    public function emailSetting()
    {
        return view('admin.setting.email', $this->data);
    }

    public function emailSettingUpdate(Request $request)
    {
        $niceNames         = [];
        $emailSettingArray = $this->validate($request, $this->emailValidateArray(), [], $niceNames);
        if (isset($emailSettingArray['mail_host'])) {
            MyString::setEnv('MAIL_HOST', $emailSettingArray['mail_host']);
        }

        if (isset($emailSettingArray['mail_port'])) {
            MyString::setEnv('MAIL_PORT', $emailSettingArray['mail_port']);
        }

        if (isset($emailSettingArray['mail_username'])) {
            MyString::setEnv('MAIL_USERNAME', $emailSettingArray['mail_username']);
        }

        if (isset($emailSettingArray['mail_password'])) {
            MyString::setEnv('MAIL_PASSWORD', $emailSettingArray['mail_password']);
        }

        if (isset($emailSettingArray['mail_encryption'])) {
            MyString::setEnv('MAIL_ENCRYPTION', $emailSettingArray['mail_encryption']);
        }

        if (isset($emailSettingArray['mail_from_address'])) {
            $address =  '"' . $emailSettingArray['mail_from_address'] . '"';
            MyString::setEnv('MAIL_FROM_ADDRESS', $address);
        }

        if (isset($emailSettingArray['mail_from_name'])) {
            $name =  '"' . $emailSettingArray['mail_from_name'] . '"';
            MyString::setEnv('MAIL_FROM_NAME', $name);
        }
        Artisan::call('optimize:clear');

        Setting::set($emailSettingArray);
        Setting::save();

        return redirect(route('admin.setting.email'))->withSuccess('The Email setting updated successfully');
    }

    // Notification Setting
    public function notificationSetting()
    {
        return view('admin.setting.notification', $this->data);
    }

    public function notificationSettingUpdate(Request $request)
    {
        if (env('DEMO_MODE')) {
            return redirect(route('admin.setting.notification'))->withError('The notification setting is disable for the demo');
        }

        $niceNames                = [];
        $notificationSettingArray = $this->validate($request, $this->notificationValidateArray(), [], $niceNames);

        $fcm_secret_key = str_replace(' ', '', $notificationSettingArray['fcm_secret_key']);

        MyString::setEnv('FCM_SECRET_KEY', $fcm_secret_key);
        Artisan::call('optimize:clear');

        Setting::set($notificationSettingArray);
        Setting::save();

        return redirect(route('admin.setting.notification'))->withSuccess('The Notification setting updated successfully.');
    }

    // Social Setting
    public function socialLoginSetting()
    {
        return view('admin.setting.social-login', $this->data);
    }

    public function socialLoginSettingUpdate(Request $request)
    {
        if ($request->settingtypesocial == 'facebook') {
            $this->facebookSetting($request);
        } else if ($request->settingtypesocial == 'google') {
            $this->googleSetting($request);
        } else {
            return redirect(route('admin.setting.social-login'));
        }
        return redirect(route('admin.setting.social-login'))->withSuccess('The Social setting updated successfully');
    }

    private function facebookSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->facebookValidateArray(), [], $niceNames);

        $facebook_key = str_replace(' ', '', $settingArray['facebook_key']);
        $facebook_secret = str_replace(' ', '_', $settingArray['facebook_secret']);
        $facebook_url = str_replace(' ', '_', $settingArray['facebook_url']);

        MyString::setEnv('FB_CLIENT_ID', $facebook_key);
        MyString::setEnv('FB_CLIENT_SECRET', $facebook_secret);
        MyString::setEnv('FB_REDIREDT_URL', $facebook_url);
        Artisan::call('optimize:clear');


        Setting::set($settingArray);
        Setting::save();
    }

    private function googleSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->googleValidateArray(), [], $niceNames);

        $google_key = str_replace(' ', '', $settingArray['google_key']);
        $google_secret = str_replace(' ', '_', $settingArray['google_secret']);
        $google_url = str_replace(' ', '_', $settingArray['google_url']);

        MyString::setEnv('GOOGLE_CLIENT_ID', $google_key);
        MyString::setEnv('GOOGLE_CLIENT_SECRET', $google_secret);
        MyString::setEnv('GOOGLE_REDIREDT_URL', $google_url);
        Artisan::call('optimize:clear');

        Setting::set($settingArray);
        Setting::save();
    }

    // otp Setting
    public function otpSetting()
    {
        return view('admin.setting.otp', $this->data);
    }

    public function otpSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->otpValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.otp'))->withSuccess('The OTP setting updated successfully');
    }

    // Homepage Setting
    public function homepageSetting()
    {
        return view('admin.setting.homepage', $this->data);
    }

    public function homepageSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->homepageValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();

        return redirect(route('admin.setting.homepage'))->withSuccess('The Home page setting updated successfully');
    }

    // SMS Setting
    public function socialSetting()
    {
        return view('admin.setting.social', $this->data);
    }

    public function socialSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->socialValidateArray(), [], $niceNames);

        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.social'))->withSuccess('The Social setting updated successfully.');
    }

    public function googleMapSetting(Request $request)
    {
        if ($request->isMethod('PUT')) {
            if (env('DEMO_MODE')) {
                return back()->withError('The google map setting is disable for the demo');
            } else {
                $this->googleMapSettingStore($request);
                return back()->withSuccess('The google map setting updated successfully.');
            }
        }
        return view('admin.setting.google-map', $this->data);
    }

    private function googleMapSettingStore($request)
    {

        $settingArray = $request->validate($this->googleMapSettingValidateArray());
        Setting::set($settingArray);
        Setting::save();
    }

    private function googleMapSettingValidateArray(): array
    {
        return [
            'google_map_api_key' => 'nullable|string|max:200',
        ];
    }

    public function purchaseKeySetting()
    {
        if (env('DEMO_MODE') == true) {
            return view('errors.404');
        }
        return view('admin.setting.purchasekey', $this->data);
    }

    public function purchaseKeySettingUpdate(Request $request)
    {
        $niceNames         = [];
        $purchasekeySettingArray = $this->validate($request, $this->purchaseKeyValidateArray(), [], $niceNames);

        MyString::setEnv('LICENSE_CODE', $purchasekeySettingArray['license_code']);

        Setting::set($purchasekeySettingArray);
        Setting::save();


        return redirect(route('admin.setting.purchasekey'))->withSuccess('The Purchase key setting updated successfully');
    }

    // Site Setting validation
    private function siteValidateArray()
    {
        return [
            'site_name'                       => 'required|string|max:100',
            'site_email'                      => 'required|string|email|max:100',
            'site_phone_number'               => 'required|numeric',
            'currency_name'                   => 'required|string|max:20',
            'currency_code'                   => 'required|string|max:20',
            'site_footer'                     => 'required|string|max:200',
            'timezone'                        => 'required|string',
            'site_logo'                       => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'fav_icon'                        => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'banner_image'                    => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'app_mockup'                      => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'site_address'                    => 'required|string|max:500',
            'banner_title'                    => 'required|string|max:500',
            'geolocation_distance_radius'     => 'required|numeric',
            'order_commission_percentage'     => 'required|numeric',
            'delivery_boy_order_amount_limit' => 'nullable|numeric',
            'order_attachment_checking'       => 'nullable|numeric',
            'ios_app_link'                    => 'nullable|string',
            'android_app_link'                => 'nullable|string',
            'locale'                          => 'nullable|string',
            'free_delivery_radius'            => 'required|numeric',
            'charge_per_kilo'                 => 'required|numeric',
            'basic_delivery_charge'           => 'required|numeric',
        ];
    }

    // SMS Setting validation
    private function smsValidateArray()
    {
        return [
            'twilio_auth_token'  => 'required|string|max:200',
            'twilio_account_sid' => 'required|string|max:200',
            'twilio_from'        => 'required|string|max:20',
            'twilio_disabled'    => 'numeric',
        ];
    }

    // App Setting validation
    private function appValidateArray()
    {
        return [
            'customer_app_name'             => 'required|string|max:200',
            'customer_app_logo'             => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'customer_splash_screen_logo'   => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'vendor_app_name'               => 'required|string|max:200',
            'vendor_app_logo'               => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'vendor_splash_screen_logo'     => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'delivery_app_name'             => 'required|string|max:200',
            'delivery_app_logo'             => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'delivery_splash_screen_logo'   => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
        ];
    }

    // Support Setting validation
    public function supportValidateArray()
    {
        return [
            'support_phone'         => 'required|string|max:20',
        ];
    }
    // Payment Setting validation

    public function sslcommerzValidateArray()
    {
        return [
            'sslcommerz_store_name'     => ['required', 'string'],
            'sslcommerz_store_id'       => ['required', 'string'],
            'sslcommerz_store_password' => ['required', 'string'],
            'sslcommerz_mode'           => ['required'],
        ];
    }

    public function phonePeValidateArray()
    {
        return [
            'phonepe_merchant_id'      => ['required', 'string'],
            'phonepe_merchant_user_id' => ['required', 'string'],
            'phonepe_env'              => ['required', 'string'],
            'phonepe_salt_key'         => ['required'],
            'phonepe_salt_index'       => ['required'],
        ];
    }
    public function paytmValidateArray()
    {
        return [
            'paytm_environment'      => ['required', 'string'],
            'paytm_merchant_id'      => ['required', 'string'],
            'paytm_merchant_key'     => ['required', 'string'],
            'paytm_merchant_website' => ['required', 'string'],
            'paytm_channel'          => ['required', 'string'],
            'paytm_industry_type'    => ['required', 'string'],
        ];
    }

    public function stripeValidateArray()
    {
        return [
            'stripe_key'         => 'required|string|max:255',
            'stripe_secret'      => 'required|string|max:255',
            'settingtypepayment' => 'required|string',
        ];
    }

    public function razorpayValidateArray()
    {
        return [
            'razorpay_key'       => 'required|string|max:255',
            'razorpay_secret'    => 'required|string|max:255',
            'settingtypepayment' => 'required|string',
        ];
    }

    private function paystackValidateArray()
    {
        return [
            'paystack_key'       => 'required|string|max:255',
            'paystack_secret'    => 'required|string|max:255',
            'settingtypepayment' => 'required|string',
        ];
    }
    private function paypalValidateArray()
    {
        return [
            'paypal_app_id'       => 'nullable|string|max:300',
            'paypal_mode' => 'nullable|string|max:20',
            'paypal_client_id' => 'required|string|max:500',
            'paypal_client_secret' => 'required|string|max:500',
            'settingtypepayment' => 'required|string',

        ];
    }

    // EMAIL Setting validation
    private function emailValidateArray()
    {
        return [
            'mail_host'         => 'required|string|max:100',
            'mail_port'         => 'required|string|max:100',
            'mail_username'     => 'required|string|max:100',
            'mail_password'     => 'required|string|max:100',
            'mail_from_name'    => 'required|string|max:100',
            'mail_from_address' => 'required|email|string|max:200',
            'mail_disabled'     => 'numeric',
        ];
    }

    // Notification Setting validation
    private function notificationValidateArray()
    {
        return [
            'fcm_secret_key'      => 'required|string',
            'firebase_api_key'    => 'required|string',
            'firebase_authDomain' => 'required|string',
            'projectId'           => 'required|string',
            'storageBucket'       => 'required|string',
            'messagingSenderId'   => 'required|string',
            'appId'               => 'required|string',
            'measurementId'       => 'required|string',
        ];
    }

    // Social Setting validation
    private function facebookValidateArray()
    {
        return [
            'facebook_key'      => 'required|string|max:255',
            'facebook_secret'   => 'required|string|max:255',
            'facebook_url'      => 'required|string|max:255',
            'settingtypesocial' => 'required|string',
        ];
    }

    private function googleValidateArray()
    {
        return [
            'google_key'        => 'required|string|max:255',
            'google_secret'     => 'required|string|max:255',
            'google_url'        => 'required|string|max:255',
            'settingtypesocial' => 'required|string',
        ];
    }

    // OTP Setting validation
    private function otpValidateArray()
    {
        return [
            'otp_type_checking' => 'required|string',
            'otp_digit_limit'   => 'required|numeric',
            'otp_expire_time'   => 'required|numeric|min:1|max:30',
        ];
    }

    // Homepage Setting validation
    private function homepageValidateArray()
    {
        return [
            'step_one_icon'          => 'required|string|max:100',
            'step_one_title'         => 'required|string|max:255',
            'step_one_description'   => 'required|string|max:255',
            'step_two_icon'          => 'required|string|max:100',
            'step_two_title'         => 'required|string|max:255',
            'step_two_description'   => 'required|string|max:255',
            'step_three_icon'        => 'required|string|max:100',
            'step_three_title'       => 'required|string|max:255',
            'step_three_description' => 'required|string|max:255',
        ];
    }

    // Social Setting validation
    private function socialValidateArray()
    {
        return [
            'facebook'  => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'youtube'   => 'nullable|string|max:100',
            'twitter'   => 'nullable|string|max:100',
        ];
    }

    // PurchaseKey Setting validation
    private function purchaseKeyValidateArray()
    {
        return [
            'license_code'      => 'required|string|max:255',
        ];
    }
}
