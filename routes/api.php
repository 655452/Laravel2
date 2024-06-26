<?php

use App\Http\Controllers\Api\v1\AddressController;
use App\Http\Controllers\Api\v1\AdminCommissionReportController;
use App\Http\Controllers\Api\v1\AdministratorController;
use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\LogoutController;
use App\Http\Controllers\Api\v1\Auth\MeController;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\Auth\SocialLoginController;
use App\Http\Controllers\Api\v1\BannerController;
use App\Http\Controllers\Api\v1\CartController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\CouponController;
use App\Http\Controllers\Api\v1\CuisineController;
use App\Http\Controllers\Api\v1\MenuItemController;
use App\Http\Controllers\Api\v1\NotificationOrderController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\OtpLoginController;
use App\Http\Controllers\Api\v1\PopularRestaurantController;
use App\Http\Controllers\Api\v1\PushNotificationController;
use App\Http\Controllers\Api\v1\RequestWithdrawController;
use App\Http\Controllers\Api\v1\ReservationController;
use App\Http\Controllers\Api\v1\RestaurantController;
use App\Http\Controllers\Api\v1\RestaurantOrderController;
use App\Http\Controllers\Api\v1\RestaurantOwnerSalesReportController;
use App\Http\Controllers\Api\v1\RestaurantReservationController;
use App\Http\Controllers\Api\v1\SearchController;
use App\Http\Controllers\Api\v1\SettingController;
use App\Http\Controllers\Api\v1\StatusController;
use App\Http\Controllers\Api\v1\TableController;
use App\Http\Controllers\Api\v1\TimeSlotController;
use App\Http\Controllers\Api\v1\TransactionController;
use App\Http\Controllers\Api\v1\WithdrawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {

    Route::post('login',                                        [LoginController::class, 'action']);
    Route::post('social-login',                                 [SocialLoginController::class, 'action']);
    Route::post('logout',                                       [LogoutController::class, 'action']);
    Route::post('reg',                                          [RegisterController::class, 'action']);
    //push notification
    Route::post('fcm-subscribe',                                [PushNotificationController::class, 'fcmSubscribe']);
    Route::post('fcm-unsubscribe',                              [PushNotificationController::class, 'fcmUnsubscribe']);

    Route::get('me',                                            [MeController::class, 'action']);
    Route::get('refresh',                                       [MeController::class, 'refresh']);
    Route::post('profile',                                      [MeController::class, 'update']);
    Route::put('change-password',                               [MeController::class, 'changePassword']);
    Route::put('device',                                        [MeController::class, 'device']);
    Route::get('review/{id}',                                   [MeController::class, 'review']);
    Route::post('review',                                       [MeController::class, 'saveReview']);
    Route::get('report/{id}',                                   [MeController::class, 'reportCheck']);
    Route::post('report',                                       [MeController::class, 'storeReport']);

    Route::get('status/{name}/{flip?}',                         [StatusController::class, 'index']); //done
    Route::get('status-order/{id}',                             [StatusController::class, 'getOrderStatus']); //done

    Route::get('status/{name}/{flip?}',                         [StatusController::class, 'index']); //done
    Route::get('settings',                                      [SettingController::class, 'index']); //done

    Route::get('banners',                                       [BannerController::class, 'index']);
    Route::post('sort-banner',                                  [BannerController::class, 'sortBanner'])->name('sort.banner');

    Route::get('category',                                      [CategoryController::class, 'index']); //done
    Route::get('category/{id}',                                 [CategoryController::class, 'index']); //done
    Route::get('category/{id}/show',                            [CategoryController::class, 'show']); //done

    Route::get('address',                                       [AddressController::class, 'index']); //done
    Route::post('address-store',                                [AddressController::class, 'store']); //done
    Route::put('address-update/update/{id}',                    [AddressController::class, 'update']);
    Route::delete('address-delete/{id}',                        [AddressController::class, 'destroy']); //done

    Route::get('cuisine',                                       [CuisineController::class, 'index']); //done
    Route::get('cuisine/{id}',                                  [CuisineController::class, 'index']); //done
    Route::get('cuisine/{id}/show',                             [CuisineController::class, 'show']); //done

    Route::get('popular-restaurant',                            [PopularRestaurantController::class, 'index']); //done
    Route::get('/restaurant/index/{id?}/{status?}/{applied?}',  [RestaurantController::class, 'index']); //done
    Route::get('restaurant/{id}',                               [RestaurantController::class, 'show']); //done
    Route::get('/search',                                       [SearchController::class, 'index']); //done

    Route::post('coupon',                                       [CouponController::class, 'apply']);

    Route::get('restaurant-menuItem/menuItem',                  [MenuItemController::class, 'index']); //done
    Route::get('restaurant-menuItem/menuItem/{id}',             [MenuItemController::class, 'index']); //done
    Route::get('restaurant-menuItem/menuItem/{id}/show',        [MenuItemController::class, 'show']); //done

    Route::get('restaurant-table/table',                        [TableController::class, 'index']); //done
    Route::get('restaurant-table/table/{id}',                   [TableController::class, 'show']); //done
    Route::post('restaurant-table/table',                       [TableController::class, 'store']); //done
    Route::put('restaurant-table/table/{id}',                   [TableController::class, 'update']); // done
    Route::delete('restaurant-table/table/{id}',                [TableController::class, 'delete']); //done

    Route::get('restaurant-timeSlot/timeSlot',                  [TimeSlotController::class, 'index']); //done

    Route::get('withdraw',                                      [WithdrawController::class, 'index']); //done

    Route::get('request-withdraw',                              [RequestWithdrawController::class, 'index']); //done
    Route::post('request-withdraw',                             [RequestWithdrawController::class, 'store']); //done
    Route::put('request-withdraw/{id}',                         [RequestWithdrawController::class, 'update']); //done
    Route::delete('request-withdraw/{id}',                      [RequestWithdrawController::class, 'delete']); //done
    //reservation
    Route::get('reservation',                                   [ReservationController::class, 'index']); //done
    Route::post('restaurant/reservation/booking',               [ReservationController::class, 'store']); //done
    Route::post('reservation/check',                            [ReservationController::class, 'check']); //done
    Route::put('reservation/status/{id}',                       [ReservationController::class, 'update']); //done

    Route::get('orders',                                        [OrderController::class, 'index']); //done
    Route::post('orders',                                       [OrderController::class, 'store']); //done
    Route::put('orders/{id}',                                   [OrderController::class, 'update']); //done
    Route::get('orders/{id}/show',                              [OrderController::class, 'show']); //done
    Route::post('orders/payment',                               [OrderController::class, 'orderPayment']); //done
    Route::get('orders/{id}/download-attachment',               [OrderController::class, 'attachment']); //done
    Route::get('orders/cancel/{id}',                            [OrderController::class, 'orderCancel']); //done

    Route::get('restaurant-order',                              [RestaurantOrderController::class, 'index']); //done
    Route::get('restaurant-order/history',                      [RestaurantOrderController::class, 'history']); //done
    Route::get('restaurant-order/{id}',                         [RestaurantOrderController::class, 'show']); //done
    Route::put('restaurant-order/{id}',                         [RestaurantOrderController::class, 'update']); //done
    Route::get('restaurant-reservation',                        [RestaurantReservationController::class, 'index']); //done

    Route::get('notification-order',                            [NotificationOrderController::class, 'index']); //done
    Route::put('notification-order/{id}/update',                [NotificationOrderController::class, 'orderAccept']); //done
    Route::put('notification-order-product-receive/{id}/update',[NotificationOrderController::class, 'OrderProductReceive']); //done
    Route::put('notification-order-status/{id}/update',         [NotificationOrderController::class, 'orderStatus']); //done
    Route::get('notification-order/{id}/show',                  [NotificationOrderController::class, 'show']); //done
    Route::get('notification-order/history',                    [NotificationOrderController::class, 'history']); //done
    Route::get('transactions',                                  [TransactionController::class, 'index']); //done
    Route::get('restaurant-owner-sales-report',                 [RestaurantOwnerSalesReportController::class, 'index']); //done
    Route::post('restaurant-owner-sales-report',                [RestaurantOwnerSalesReportController::class, 'index']); //done
    Route::get('admin-commission-report',                       [AdminCommissionReportController::class, 'index']); //done
    Route::post('admin-commission-report',                      [AdminCommissionReportController::class, 'index']); //done

    Route::get('cart',                                          [CartController::class, 'index']);
    Route::post('cart',                                         [CartController::class, 'store']);
    Route::get('cart/{id}',                                     [CartController::class, 'remove']);
    Route::post('cart-quantity',                                [CartController::class, 'quantity']);
    Route::resource('administrators',                         AdministratorController::class);
    Route::get('get-administrators',                            [AdministratorController::class, 'getAdministrators'])->name('administrators.get-administrators');

    //otp login
    Route::post('otp-login',                                    [OtpLoginController::class, 'getOtp']);
    Route::post('verify-otp',                                   [OtpLoginController::class, 'verifyOtp']);
});
