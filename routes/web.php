<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinalController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\PurchaseCodeController;
use App\Http\Controllers\Admin\CuisineController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UpdateAppController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\SocialController;
use App\Http\Controllers\WebNotificationController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\PrivacyController;
use App\Http\Controllers\Admin\DeliveryBoyController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Frontend\RestaurantController;
use App\Http\Controllers\Admin\CustomerReportController;
use App\Http\Controllers\Admin\WithdrawReportController;
use App\Http\Controllers\Frontend\ReservationController;
use App\Http\Controllers\Admin\RequestWithdrawController;
use App\Http\Controllers\Admin\RestaurantOwnerController;
use App\Http\Controllers\Frontend\FrontendPageController;
use App\Http\Controllers\Frontend\LocalizationController;
use App\Http\Controllers\Admin\CollectionReportController;
use App\Http\Controllers\Admin\PushNotificationController;
use App\Http\Controllers\Admin\OrderNotificationController;
use App\Http\Controllers\Admin\ReservationReportController;
use App\Http\Controllers\Admin\CreditBalanceReportController;
use App\Http\Controllers\Admin\UpdateScriptVersionController;
use App\Http\Controllers\Admin\AdminCommissionReportController;
use RachidLaasri\LaravelInstaller\Controllers\UpdateController;
use App\Http\Controllers\Admin\RestaurantOwnerSalesReportController;
use App\Http\Controllers\Admin\CashOnDeliveryOrderBalanceReportController;
use App\Http\Controllers\Admin\RestaurantController as RestaurantsController;
use App\Http\Controllers\Admin\ReservationController as ReservationsController;

Route::group(['middleware' => ['installed', 'license-activate']], function () {
    Auth::routes(['verify' => false]);
});

Route::group(['middleware' => ['installed', 'not-verified']], function () {
    Route::get('/license-activate',                         [PurchaseCodeController::class, 'licenseCodeActivate'])->name('license-activate');
});

Route::group(['prefix' => 'install', 'as' => 'LaravelInstaller::', 'middleware' => ['web', 'install']], function () {
    Route::post('environment/saveWizard',                   [EnvironmentController::class, 'saveWizard'])->name('environmentSaveWizard');
    Route::get('purchase-code',                             [PurchaseCodeController::class, 'index'])->name('purchase_code');
    Route::post('purchase-code',                            [PurchaseCodeController::class, 'action'])->name('purchase_code.check');
    Route::get('final',                                     [FinalController::class, 'finish'])->name('final');
});

Route::group(['middleware' => ['installed', 'license-activate']], function () {
    Route::get('/home',                                     [HomeController::class, 'index'])->name('home');
    Route::get('/',                                         [HomeController::class, 'index'])->name('home');
    Route::get('restaurant/{restaurant}',                   [RestaurantController::class, 'show'])->name('restaurant.show');
    Route::post('restaurant/ratings',                       [RestaurantController::class, 'Ratings'])->name('restaurant.ratings-update')->middleware('auth');

    Route::get('reservation/booking',                       [ReservationController::class, 'booking'])->name('restaurant.reservation')->middleware('auth');
    Route::get('restaurant/reservation/booking',            [ReservationController::class, 'store'])->name('restaurant.reservation.store')->middleware('auth');
    Route::post('reservation/check',                        [ReservationController::class, 'check'])->name('reservation.check');
    Route::get('reservation/confirmation',                  [ReservationController::class, 'confirmation'])->name('reservation.confirmation')->middleware('auth');

    Route::get('checkout',                                  [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
    Route::post('checkout',                                 [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
    Route::get('/payment/callback',                         [CheckoutController::class, 'PaystackCallback'])->name('paystack.callback')->middleware('auth');

    Route::post('paytm/status', [CheckoutController::class, 'paytmCallback']);

    Route::post('phonepe/status', [CheckoutController::class, 'phonepeCallback']);

    Route::post('sslcommerz/success', [CheckoutController::class, 'sslcommerzSuccess']);
    Route::post('sslcommerz/fail', [CheckoutController::class, 'sslcommerzFail']);
    Route::post('sslcommerz/cancel', [CheckoutController::class, 'sslcommerzCancle']);

    Route::get('account/profile',                           [AccountController::class, 'index'])->name('account.profile')->middleware('auth');
    Route::get('account/password',                          [AccountController::class, 'getPassword'])->name('account.password')->middleware('auth');
    Route::put('account/password',                          [AccountController::class, 'password_update'])->name('account.password.update')->middleware('auth');
    Route::get('account/update',                            [AccountController::class, 'profileUpdate'])->name('account.profile.index')->middleware('auth');
    Route::put('account/update/{profile}',                  [AccountController::class, 'update'])->name('account.profile.update')->middleware('auth');
    Route::get('account/reservations',                      [AccountController::class, 'getReservation'])->name('account.reservations')->middleware('auth');
    Route::get('account/report/{id}',                       [AccountController::class, 'reportView'])->name('account.report')->middleware('auth');
    Route::post('account/reports',                          [AccountController::class, 'storeReport'])->name('account.store-report')->middleware('auth');
    Route::get('account/order',                             [AccountController::class, 'getOrder'])->name('account.order')->middleware('auth');
    Route::get('account/get-order',                         [AccountController::class, 'getOrderList'])->name('account.get-order')->middleware('auth');
    Route::get('account/order/{id}',                        [AccountController::class, 'orderShow'])->name('account.order.show')->middleware('auth');
    Route::get('account/order-cancel/{id}',                 [AccountController::class, 'orderCancel'])->name('account.order.cancel')->middleware('auth');

    Route::get('account/order-file/{id}',                   [AccountController::class, 'getDownloadFile'])->name('account.order.file')->middleware('auth');

    Route::get('account/transaction',                       [AccountController::class, 'getTransactions'])->name('account.transaction')->middleware('auth');
    Route::get('account/review',                            [AccountController::class, 'review'])->name('account.review')->middleware('auth');
    Route::get('account/get-review',                        [AccountController::class, 'getReview'])->name('account.get-review')->middleware('auth');

    Route::get('account/shop-product-ratings/{shop}/{product}', [AccountController::class, 'shopProductRatings'])->name('account.shop-product-ratings')->middleware('auth');
    Route::post('account/shop-product-ratings-update',      [AccountController::class, 'shopProductRatingsUpdate'])->name('account.shop-product-ratings-update')->middleware('auth');

    Route::post('/address',                                 [AddressController::class, 'store'])->name('address.store');
    Route::get('/address/edit/{id}',                        [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address-update/update/{id}',               [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/delete/{id}',                   [AddressController::class, 'destroy'])->name('address.delete');
    Route::get('/search',                                   [SearchController::class, 'filter'])->name('search');
    Route::get('/{shop}/products/search',                   [SearchController::class, 'filterProduct'])->name('search-product');
    Route::get('/privacy',                                  [PrivacyController::class])->name('privacy');
    Route::get('/terms',                                    [TermController::class])->name('terms');
    Route::get('/contact',                                  [ContactController::class])->name('contact');
    Route::get('lang/{locale}',                             [LocalizationController::class, 'index'])->name('lang.index');
    Route::post('/contact',                                  [ContactController::class, 'store'])->name('contact.store');
    Route::get('page/{slug}',                               [FrontendPageController::class, 'index'])->name('page');
    //social-login-routes
    Route::get('auth/{provider}',                           [SocialController::class, 'socialRedirect'])->name('social-login');
    Route::get('auth/{provider}/callback',                  [SocialController::class, 'loginWithSocial'])->name('callback');

    //paypal
    Route::get('success-transaction',                       [CheckoutController::class, 'paypalSuccessTransaction'])->name('successTransaction');
    Route::get('cancel-transaction',                        [CheckoutController::class, 'paypalCancelTransaction'])->name('cancelTransaction');
});


Route::post('store-token', [WebNotificationController::class, 'store'])->name('store.token');

Route::redirect('/admin', '/admin/dashboard')->middleware('backend_permission');

Route::group(['prefix' => 'admin', 'middleware' => ['installed'], 'as' => 'admin.'], function () {
    Route::get('login', [LoginController::class, 'showLoginForm']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'installed', 'license-activate', 'backend_permission'], 'as' => 'admin.'], function () {
    Route::get('dashboard',                                 [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('day-wise-income-order',                    [DashboardController::class, 'dayWiseIncomeOrder'])->name('dashboard.day-wise-income-order');
    Route::get('profile',                                   [ProfileController::class, 'index'])->name('profile');
    Route::put('profile/update/{profile}',                  [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/change',                            [ProfileController::class, 'change'])->name('profile.change');
    Route::post('profile/save-address',                     [ProfileController::class, 'saveAddress'])->name('profile.save-address');
    Route::delete('profile/delete-address/{id}',            [ProfileController::class, 'deleteAddress'])->name('profile.delete-address');
    Route::put('profile/profileBank/{bank}',                [ProfileController::class, 'profileBank'])->name('profile-bank');

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('/',                                     [SettingController::class, 'index'])->name('index');
        Route::post('/',                                    [SettingController::class, 'siteSettingUpdate'])->name('site-update');
        Route::get('sms',                                   [SettingController::class, 'smsSetting'])->name('sms');
        Route::post('sms',                                  [SettingController::class, 'smsSettingUpdate'])->name('sms-update');
        Route::get('payment',                               [SettingController::class, 'paymentSetting'])->name('payment');
        Route::post('payment',                              [SettingController::class,  'paymentSettingUpdate'])->name('payment-update');
        Route::get('email',                                 [SettingController::class, 'emailSetting'])->name('email');
        Route::post('email',                                [SettingController::class, 'emailSettingUpdate'])->name('email-update');
        Route::get('notification',                          [SettingController::class, 'notificationSetting'])->name('notification');
        Route::post('notification',                         [SettingController::class, 'notificationSettingUpdate'])->name('notification-update');
        Route::get('social-login',                          [SettingController::class, 'socialLoginSetting'])->name('social-login');
        Route::post('social-login',                         [SettingController::class, 'socialLoginSettingUpdate'])->name('social-login-update');
        Route::get('otp',                                   [SettingController::class, 'otpSetting'])->name('otp');
        Route::post('otp',                                  [SettingController::class, 'otpSettingUpdate'])->name('otp-update');
        Route::get('homepage',                              [SettingController::class, 'homepageSetting'])->name('homepage');
        Route::post('homepage',                             [SettingController::class, 'homepageSettingUpdate'])->name('homepage-update');
        Route::get('social',                                [SettingController::class, 'socialSetting'])->name('social');
        Route::post('social',                               [SettingController::class, 'socialSettingUpdate'])->name('social-update');
        Route::get('app-setting',                           [SettingController::class, 'appSetting'])->name('app');
        Route::post('app-setting',                          [SettingController::class, 'appSettingUpdate'])->name('app-update');
        Route::get('support-setting',                       [SettingController::class, 'supportSetting'])->name('support');
        Route::post('support-setting',                      [SettingController::class, 'supportSettingUpdate'])->name('support-update');
        Route::match(['get', 'put'], 'google-map',          [SettingController::class, 'googleMapSetting'])->name('google-map');
        Route::get('purchasekey',                           [SettingController::class, 'purchaseKeySetting'])->name('purchasekey');
        Route::post('purchasekey',                          [SettingController::class, 'purchaseKeySettingUpdate'])->name('purchasekey-update');
    });

    Route::resource('page',                                  PageController::class);
    Route::get('get-page',                                  [PageController::class, 'getPage'])->name('page.get-page');
    Route::get('rating',                                    [RatingController::class, 'index'])->name('rating.index');
    Route::put('rating/{id}',                               [RatingController::class, 'update'])->name('rating.update');
    Route::get('get-rating',                                [RatingController::class, 'getRating'])->name('rating.get-rating');

    Route::resource('category',                              CategoryController::class);
    Route::resource('cuisine',                               CuisineController::class);
    Route::get('test-coupon',                               [CouponController::class, 'testFunction']);
    Route::resource('menu-items',                            MenuItemController::class);
    Route::get('menu-items/{id}/modify',                    [MenuItemController::class, 'modify'])->name('menu-items.modify');
    Route::put('menu-items/{id}/modify',                    [MenuItemController::class, 'modifyUpdate'])->name('menu-items.modify');
    Route::resource('reservation',                          ReservationsController::class);
    Route::post('reservation/timeeSlot',                    [ReservationsController::class, 'timeSlot'])->name('reservation.timeSlot');
    Route::post('reservation/user',                         [ReservationsController::class, 'user'])->name('reservation.user');
    Route::get('reservation/status/{id}/{status}',          [ReservationsController::class, 'status'])->name('reservation.status');


    Route::post('menu-items/getMedia',                      [MenuItemController::class, 'getMedia'])->name('menu-items.getMedia');
    Route::post('menu-items/storeMedia',                    [MenuItemController::class, 'storeMedia'])->name('menu-items.storeMedia');
    Route::post('menu-items/updateMedia/{menuitem}',        [MenuItemController::class, 'updateMedia'])->name('menu-items.updateMedia');
    Route::post('menu-items/removeMedia',                   [MenuItemController::class, 'removeMedia'])->name('menu-items.removeMedia');

    Route::resource('banner',                           BannerController::class)->except('show');
    Route::post('sort-banner',                              [BannerController::class, 'sortBanner'])->name('sort.banner');

    Route::resource('request-withdraw',                RequestWithdrawController::class);
    Route::get('get-request-withdraw',                      [RequestWithdrawController::class, 'getRequestWithdraw'])->name('request-withdraw.get-request-withdraw');
    Route::post('request-get-user-info',                    [RequestWithdrawController::class, 'getUserInfo'])->name('request-withdraw.get-user-info');


    Route::resource('administrators',                   AdministratorController::class);
    Route::get('get-administrators',                        [AdministratorController::class, 'getAdministrators'])->name('administrators.get-administrators');

    Route::resource('restaurant-owners',                  RestaurantOwnerController::class);

    Route::resource('customers',                         CustomerController::class);
    Route::get('get-customers',                             [CustomerController::class, 'getCustomers'])->name('customers.get-customers');

    Route::resource('delivery-boys',                         DeliveryBoyController::class);
    Route::get('get-delivery-boys',                         [DeliveryBoyController::class, 'getDeliveryBoy'])->name('delivery-boys.get-delivery-boys');
    Route::get('get-order-history',                         [DeliveryBoyController::class, 'history'])->name('delivery-boys.get-order-history');
    Route::resource('qr-code',                              QrCodeController::class);

    Route::post('qr-code/preview',                          [QrCodeController::class, 'preview'])->name('qr-code.post');

    Route::get('order-notification',                        [OrderNotificationController::class, 'index'])->name('order-notification.index');
    Route::get('order-notification/{id}/accept/{deliveryStatus}', [OrderNotificationController::class, 'accept'])->name('order-notification.accept');
    Route::get('get-order-notification',                    [OrderNotificationController::class, 'getOrderNotification'])->name('order-notification.get-order-notifications');

    Route::resource('collection',                            CollectionController::class);
    Route::get('get-collection',                            [CollectionController::class, 'getCollection'])->name('collection.get-collection');
    Route::post('get-collection-delivery-boy',              [CollectionController::class, 'getDeliveryBoy'])->name('collection.get-delivery-boy');
    //order status route
    Route::post('orders/{order}/product-receive',           [OrderController::class, 'productReceive'])->name('orders.product-receive');
    Route::get('orders/product-receive/{id}/{status}',      [OrderController::class, 'productReceiveIndex'])->name('orders.product-receive-index');
    Route::get('order/change-status/{id}/{status}',         [OrderController::class, 'changeStatus'])->name('order.change-status');

    Route::get('live-orders',                               [OrderController::class, 'liveOrders'])->name('orders.live-orders');
    Route::get('get-live-orders',                           [OrderController::class, 'getliveOrders'])->name('orders.get-live-Order');

    Route::resource('coupon',                               CouponController::class);
    Route::get('test-coupon',                               [CouponController::class, 'testFunction']);

    Route::resource('restaurants',                           RestaurantsController::class);
    Route::get('get-restaurant',                            [RestaurantsController::class, 'getRestaurant'])->name('restaurant.get-restaurant');
    Route::get('get-menu-item',                             [RestaurantsController::class, 'getMenuItem'])->name('restaurant.get-menu-items');
    Route::post('restaurant-store',                         [RestaurantsController::class, 'restaurantStore'])->name('restaurant.restaurant-store');
    Route::post('getMedia',                                 [RestaurantsController::class, 'getMedia'])->name('restaurant.getMedia');
    Route::post('storeMedia',                               [RestaurantsController::class, 'storeMedia'])->name('restaurant.storeMedia');
    Route::post('storeMedia/{restaurant}',                  [RestaurantsController::class, 'updateMedia'])->name('restaurant.updateMedia');
    Route::post('removeMedia',                              [RestaurantsController::class, 'removeMedia'])->name('restaurant.removeMedia');
    Route::post('deleteMedia',                              [RestaurantsController::class, 'deleteMedia'])->name('restaurant.deleteMedia');
    Route::get('restaurant-edit/{restaurant}',              [RestaurantsController::class, 'restaurantEdit'])->name('restaurant.restaurant-edit');
    Route::put('restaurant-update/{restaurant}',            [RestaurantsController::class, 'restaurantUpdate'])->name('restaurant.restaurant-update');

    Route::resource('orders',                                OrderController::class);
    Route::get('orders/{order}/delivery',                   [OrderController::class, 'delivery'])->name('orders.delivery');
    Route::get('get-orders',                                [OrderController::class, 'getOrder'])->name('orders.get-orders');
    Route::get('orders/order-file/{id}',                    [OrderController::class, 'getDownloadFile'])->name('orders.order-file');

    Route::resource('complaints',                            ComplaintController::class);
    Route::get('get-complaints',                            [ComplaintController::class, 'getComplaint'])->name('complaint.get-complaints');
    Route::get('complaints/change-status/{id}/{status}',    [ComplaintController::class, 'changeStatus'])->name('complaint.change-status');

    Route::resource('updates',                               UpdateController::class);
    Route::get('get-updates',                               [UpdateController::class, 'getUpdates'])->name('updates.get-updates');
    Route::get('checking-updates',                          [UpdateController::class, 'checking'])->name('updates.checking-updates');
    Route::get('update',                                    [UpdateController::class, 'update'])->name('updates.update');
    Route::get('update-log',                                [UpdateController::class, 'log'])->name('updates.update-log');

    Route::get('payment',                                   [PaymentController::class, 'index'])->name('payment.index');
    Route::get('payment/invoice',                           [PaymentController::class, 'invoice'])->name('payment.invoice');
    Route::get('payment/cancel',                            [PaymentController::class, 'cancel'])->name('payment.cancel');

    Route::get('transaction',                               [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('get-transaction',                           [TransactionController::class, 'getTransaction'])->name('transaction.get-transaction');

    Route::get('restaurant-owner-sales-report',             [RestaurantOwnerSalesReportController::class, 'index'])->name('restaurant-owner-sales-report.index');
    Route::post('restaurant-owner-sales-report',            [RestaurantOwnerSalesReportController::class, 'index'])->name('restaurant-owner-sales-report.index');

    Route::get('admin-commission-report',                   [AdminCommissionReportController::class, 'index'])->name('admin-commission-report.index');
    Route::post('admin-commission-report',                  [AdminCommissionReportController::class, 'index'])->name('admin-commission-report.index');

    Route::get('credit-balance-report',                     [CreditBalanceReportController::class, 'index'])->name('credit-balance-report.index');
    Route::post('credit-balance-report',                    [CreditBalanceReportController::class, 'index'])->name('credit-balance-report.index');
    Route::post('get-role-user',                            [CreditBalanceReportController::class, 'getUsers'])->name('get-role-user');

    Route::get('cash-on-delivery-order-balance-report',     [CashOnDeliveryOrderBalanceReportController::class, 'index'])->name('cash-on-delivery-order-balance-report.index');
    Route::post('cash-on-delivery-order-balance-report',    [CashOnDeliveryOrderBalanceReportController::class, 'index'])->name('cash-on-delivery-order-balance-report.index');

    Route::get('delivery-boy-collection-report',            [CollectionReportController::class, 'index'])->name('delivery-boy-collection-report.index');
    Route::post('delivery-boy-collection-report',           [CollectionReportController::class, 'index'])->name('delivery-boy-collection-report.index');

    Route::get('withdraw-report',                           [WithdrawReportController::class, 'index'])->name('withdraw-report.index');
    Route::post('withdraw-report',                          [WithdrawReportController::class, 'index'])->name('withdraw-report.index');

    Route::get('reservation-report',                        [ReservationReportController::class, 'index'])->name('reservation-report.index');
    Route::post('reservation-report',                       [ReservationReportController::class, 'index'])->name('reservation-report.index');

    Route::get('customer-report',                           [CustomerReportController::class, 'index'])->name('customer-report.index');
    Route::post('customer-report',                          [CustomerReportController::class, 'index'])->name('customer-report.index');

    Route::resource('role',                      RoleController::class);
    Route::post('role/save-permission/{id}',                [RoleController::class, 'savePermission'])->name('role.save-permission');

    Route::resource('withdraw',                  WithdrawController::class);
    Route::get('withdraw/create/{id?}',                     [WithdrawController::class, 'create'])->name('withdraw.create');
    Route::get('get-withdraw',                              [WithdrawController::class, 'getWithdraw'])->name('withdraw.get-withdraw');
    Route::post('get-user-info',                            [WithdrawController::class, 'getUserInfo'])->name('withdraw.get-user-info');

    Route::resource('time-slots',                         TimeSlotController::class);
    Route::resource('tables',                             TableController::class);
    Route::get('get-tables',                                [TableController::class, 'getTable'])->name('tables.get-tables');
    Route::resource('addons',                             AddonController::class);

    Route::get('file-import-export',                        [RestaurantsController::class, 'fileImportExport'])->name('import-restaurant');
    Route::post('file-import',                              [RestaurantsController::class, 'fileImport'])->name('file-import');
    Route::get('file-export',                               [RestaurantsController::class, 'fileExport'])->name('file-export');

    //Bank Route
    Route::resource('bank',                               BankController::class);
    Route::get('get-bank',                                  [BankController::class, 'getBank'])->name('get-bank');

    //Language Route
    Route::resource('language',                           LanguageController::class);
    Route::get('get-language',                              [LanguageController::class, 'getLanguage'])->name('language.get-language');
    Route::get('language/change-status/{id}/{status}',      [LanguageController::class, 'changeStatus'])->name('language.change-status');

    //Push Notification
    Route::resource('push-notification',                  PushNotificationController::class);
    Route::get('get-notification',                          [PushNotificationController::class, 'getNotification'])->name('push-notification.get-notification');

    //Update AppController
    Route::resource('update',                             UpdateAppController::class);
    //update version
    Route::get('update-version/update',                     [UpdateScriptVersionController::class, 'update'])->name('updateVersion.update');

    //user module
    Route::resource('user',                     UserController::class);
    Route::get('get-users',                     [UserController::class, 'getUsers'])->name('users.get-users');
});
