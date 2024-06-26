<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;



// Home
Breadcrumbs::for('dashboard', function ( $trail) {
    $trail->push(trans('validation.attributes.dashboard'), route('admin.dashboard.index'));
});

Breadcrumbs::for('profile', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.profile'));
});

// Dashboard / Setting
Breadcrumbs::for('setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.settings'));
});

// Dashboard / Email Setting
Breadcrumbs::for('sms-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.sms_settings'));
});

// Dashboard / App Setting
Breadcrumbs::for('app-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.app_settings'));
});
// Dashboard / App Setting
Breadcrumbs::for('support-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.support_settings'));
});

// Dashboard / Email Setting
Breadcrumbs::for('emailsetting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.emailsettings'));
});

// Dashboard / SMS Setting
Breadcrumbs::for('smssetting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.smssetting'));
});

// Dashboard / SMS Setting
Breadcrumbs::for('notificationsetting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.notificationsetting'));
});

// Dashboard / Payment Setting
Breadcrumbs::for('payment-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.payment_settings'));
});
// Dashboard / Payment Setting
Breadcrumbs::for('google-map-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.google_map_setting'));
});

// Setting purchasekey-setting Module
Breadcrumbs::for('purchasekey-setting', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.purchasekey_settings'));
});

// Dashboard / Location
Breadcrumbs::for('locations', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.locations'), route('admin.location.index'));
});

// Dashboard / Location / Add
Breadcrumbs::for('location/add', function ( $trail) {
    $trail->parent('locations');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Location / Edit
Breadcrumbs::for('location/edit', function ( $trail) {
    $trail->parent('locations');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Area
Breadcrumbs::for('areas', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.areas'), route('admin.area.index'));
});

// Dashboard / Area / Add
Breadcrumbs::for('area/add', function ( $trail) {
    $trail->parent('areas');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Area / Edit
Breadcrumbs::for('area/edit', function ( $trail) {
    $trail->parent('areas');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Plan
Breadcrumbs::for('plans', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.plans'), route('admin.plan.index'));
});

// Dashboard / Plan / Add
Breadcrumbs::for('plan/add', function ( $trail) {
    $trail->parent('plans');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Plan / Edit
Breadcrumbs::for('plan/edit', function ( $trail) {
    $trail->parent('plans');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / complaints
Breadcrumbs::for('complaints', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.complaints'), route('admin.complaints.index'));
});

// Dashboard / complaints / View
Breadcrumbs::for('complaints/view', function ( $trail) {
    $trail->parent('complaints');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / category
Breadcrumbs::for('categories', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.categories'), route('admin.category.index'));
});

// Dashboard / categories / Add
Breadcrumbs::for('categories/add', function ( $trail) {
    $trail->parent('categories');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / categories / Edit
Breadcrumbs::for('categories/edit', function ( $trail) {
    $trail->parent('categories');
    $trail->push(trans('validation.attributes.edit'));
});


// Dashboard / cuisines
Breadcrumbs::for('cuisines', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.cuisines'), route('admin.cuisine.index'));
});

// Dashboard / categories / Add
Breadcrumbs::for('cuisines/add', function ( $trail) {
    $trail->parent('cuisines');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / categories / Edit
Breadcrumbs::for('cuisines/edit', function ( $trail) {
    $trail->parent('cuisines');
    $trail->push(trans('validation.attributes.edit'));
});


// Dashboard / coupons
Breadcrumbs::for ('coupons', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.coupon'), route('admin.coupon.index'));
});

// Dashboard / categories / Add
Breadcrumbs::for ('coupons/add', function ( $trail) {
    $trail->parent('coupons');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / categories / Edit
Breadcrumbs::for ('coupons/edit', function ( $trail) {
    $trail->parent('coupons');
    $trail->push(trans('validation.attributes.edit'));
});

Breadcrumbs::for ('coupons/show', function ( $trail) {
    $trail->parent('coupons');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / reservations
Breadcrumbs::for('reservations', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.reservations'), route('admin.reservation.index'));
});

// Dashboard / categories / Add
Breadcrumbs::for('reservations/add', function ( $trail) {
    $trail->parent('reservations');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / categories / Edit
Breadcrumbs::for('reservations/edit', function ( $trail) {
    $trail->parent('reservations');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / categories / view
Breadcrumbs::for('reservations/view', function ( $trail) {
    $trail->parent('reservations');
    $trail->push(trans('validation.attributes.view'));
});



/* Menu Items breadcrumbs */
// Dashboard / category
Breadcrumbs::for('menu-items', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.menu-items'), route('admin.menu-items.index'));
});

// Dashboard / menu-items / Add
Breadcrumbs::for('menu-items/view', function ( $trail) {
    $trail->parent('menu-items');
    $trail->push(trans('validation.attributes.view'));
});

Breadcrumbs::for('menu-items/add', function ( $trail) {
    $trail->parent('menu-items');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / menu-items / Edit
Breadcrumbs::for('menu-items/edit', function ( $trail) {
    $trail->parent('menu-items');
    $trail->push(trans('validation.attributes.edit'));
});
/* Menu Items breadcrumbs ends */

/* Product breadcrumbs */
// Dashboard / request-products
Breadcrumbs::for('request-products', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.request-products'), route('admin.request-products.index'));
});

// Dashboard / request-products / Add
Breadcrumbs::for('request-products/view', function ( $trail) {
    $trail->parent('request-products');
    $trail->push(trans('validation.attributes.view'));
});

Breadcrumbs::for('request-products/add', function ( $trail) {
    $trail->parent('request-products');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / request-products / Edit
Breadcrumbs::for('request-products/edit', function ( $trail) {
    $trail->parent('request-products');
    $trail->push(trans('validation.attributes.edit'));
});
/* Product breadcrumbs ends */

// Dashboard / Shop
Breadcrumbs::for('restaurants', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.restaurants'), route('admin.restaurants.index'));
});

// Dashboard / restaurant / Add
Breadcrumbs::for('restaurant/add', function ( $trail) {
    $trail->parent('restaurants');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / restaurant / Edit
Breadcrumbs::for('restaurant/edit', function ( $trail) {
    $trail->parent('restaurants');
    $trail->push(trans('validation.attributes.edit'));
});
// Dashboard / restaurant / View
Breadcrumbs::for('restaurant/view', function ( $trail) {
    $trail->parent('restaurants');
    $trail->push(trans('validation.attributes.view'));
});

Breadcrumbs::for('restaurant/restaurant-product', function ( $trail) {
    $trail->parent('restaurants');
    $trail->push(trans('validation.attributes.restaurantproducts'));
});

Breadcrumbs::for('restaurant-product-add', function ($trail, $restaurant) {
    $trail->parent('restaurants');
    $trail->push(trans('validation.attributes.restaurantproducts'), route('admin.restaurant.products', $restaurant));
    $trail->push(trans('validation.attributes.add'));
});

Breadcrumbs::for('restaurant-product-edit', function ($trail, $restaurant) {
    $trail->parent('restaurants');
    $trail->push(trans('validation.attributes.restaurantproducts'), route('admin.restaurant.products', $restaurant));
    $trail->push(trans('validation.attributes.edit'));
});

Breadcrumbs::for('live-orders', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.live_orders'), route('admin.orders.live-orders'));
});

Breadcrumbs::for('orders', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.orders'), route('admin.orders.index'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('orders/edit', function ( $trail) {
    $trail->parent('orders');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('orders/view', function ( $trail) {
    $trail->parent('orders');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('orders/delivery', function ( $trail) {
    $trail->parent('orders');
    $trail->push(trans('validation.attributes.delivery'));
});

// Dashboard / User
Breadcrumbs::for('administrators', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.administrators'), route('admin.administrators.index'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('administrators/add', function ( $trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('administrators/edit', function ( $trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('administrators/view', function ( $trail) {
    $trail->parent('administrators');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / User
Breadcrumbs::for('customers', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.customers'), route('admin.customers.index'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('customers/edit', function ( $trail) {
    $trail->parent('customers');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Shop / Edit
Breadcrumbs::for('customers/view', function ( $trail) {
    $trail->parent('customers');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Restaurant Owners
Breadcrumbs::for('restaurant-owners', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.restaurant-owners'), route('admin.restaurant-owners.index'));
});

// Dashboard / Restaurant Owners / Add
Breadcrumbs::for('restaurant-owners/add', function ( $trail) {
    $trail->parent('restaurant-owners');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Restaurant Owners / Edit
Breadcrumbs::for('restaurant-owners/edit', function ( $trail) {
    $trail->parent('restaurant-owners');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Restaurant Owners / View
Breadcrumbs::for('restaurant-owners/view', function ( $trail) {
    $trail->parent('restaurant-owners');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Import
Breadcrumbs::for('file-import-export', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.file-import-export'), route('admin.import-restaurant'));
});

// Dashboard / User
Breadcrumbs::for('delivery-boys', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.delivery-boys'), route('admin.delivery-boys.index'));
});

// Dashboard / delivery boys / Edit
Breadcrumbs::for('delivery-boys/add', function ( $trail) {
    $trail->parent('delivery-boys');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / delivery boys / Edit
Breadcrumbs::for('delivery-boys/edit', function ( $trail) {
    $trail->parent('delivery-boys');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / delivery boys / Edit
Breadcrumbs::for('delivery-boys/view', function ( $trail) {
    $trail->parent('delivery-boys');
    $trail->push(trans('validation.attributes.view'));
});


Breadcrumbs::for('updates', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.updates'), route('admin.updates.index'));
});

Breadcrumbs::for('transaction', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.transaction'), route('admin.transaction.index'));
});

Breadcrumbs::for('restaurant-owner-sales-report', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.restaurant-owner-sales-report'), route('admin.restaurant-owner-sales-report.index'));
});
Breadcrumbs::for('admin-commission-report', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.admin-commission-report'), route('admin.admin-commission-report.index'));
});

Breadcrumbs::for('credit-balance-report', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.credit-balance-report'), route('admin.credit-balance-report.index'));
});

Breadcrumbs::for('cash-on-delivery-order-balance-report', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.cash-on-delivery-order-balance-report'), route('admin.cash-on-delivery-order-balance-report.index'));
});

Breadcrumbs::for('delivery-boy-collection-report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.delivery-boy-collection-report'), route('admin.delivery-boy-collection-report.index'));
});
Breadcrumbs::for('withdraw-report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.withdraw-report'), route('admin.withdraw-report.index'));
});

Breadcrumbs::for('customer-report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.customer-report'), route('admin.customer-report.index'));
});

Breadcrumbs::for('reservation-report', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.reservation-report'), route('admin.reservation-report.index'));
});

// Dashboard / Role
Breadcrumbs::for('roles', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.roles'), route('admin.role.index'));
});

// Dashboard / Role / Add
Breadcrumbs::for('role/add', function ( $trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Role / Edit
Breadcrumbs::for('role/edit', function ( $trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Role / View
Breadcrumbs::for('role/view', function ( $trail) {
    $trail->parent('roles');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Banners
Breadcrumbs::for('banners', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.banners'), route('admin.banner.index'));
});

// Dashboard / Banner / Add
Breadcrumbs::for('banners/add', function ( $trail) {
    $trail->parent('banners');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Banner / Edit
Breadcrumbs::for('banners/edit', function ( $trail) {
    $trail->parent('banners');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Collection
Breadcrumbs::for('collections', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.collections'), route('admin.collection.index'));
});

// Dashboard / Collection / Add
Breadcrumbs::for('collection/add', function ( $trail) {
    $trail->parent('collections');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Collection / Edit
Breadcrumbs::for('collection/edit', function ( $trail) {
    $trail->parent('collections');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Collection / View
Breadcrumbs::for('collection/view', function ( $trail) {
    $trail->parent('collections');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Order Notification
Breadcrumbs::for('order-notifications', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.order_notifications'), route('admin.order-notification.index'));
});

// Dashboard / Order Notification / Add
Breadcrumbs::for('order-notification/add', function ( $trail) {
    $trail->parent('order-notifications');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Order Notification / Edit
Breadcrumbs::for('order-notification/edit', function ( $trail) {
    $trail->parent('order-notifications');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Order Notification / View
Breadcrumbs::for('order-notification/view', function ( $trail) {
    $trail->parent('order-notifications');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / Withdraw
Breadcrumbs::for('withdraw', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.withdraw'), route('admin.withdraw.index'));
});

// Dashboard / withdraw / Add
Breadcrumbs::for('withdraw/add', function ( $trail) {
    $trail->parent('withdraw');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / withdraw / Edit
Breadcrumbs::for('withdraw/edit', function ( $trail) {
    $trail->parent('withdraw');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Request Withdraw
Breadcrumbs::for('request-withdraw', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.request-withdraw'), route('admin.request-withdraw.index'));
});

// Dashboard / Request Withdraw / Add
Breadcrumbs::for('request-withdraw/add', function ( $trail) {
    $trail->parent('request-withdraw');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Request Withdraw / Edit
Breadcrumbs::for('request-withdraw/edit', function ( $trail) {
    $trail->parent('request-withdraw');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Page
Breadcrumbs::for('pages', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.pages'), route('admin.page.index'));
});

// Dashboard / Page / Add
Breadcrumbs::for('pages/add', function ( $trail) {
    $trail->parent('pages');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / Page / Edit
Breadcrumbs::for('pages/edit', function ( $trail) {
    $trail->parent('pages');
    $trail->push(trans('validation.attributes.edit'));
});
// Setting Module
Breadcrumbs::for('site-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.site_settings'));
});

// Setting Module
Breadcrumbs::for('email-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.email_settings'));
});

// Setting Module
Breadcrumbs::for('notification-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.notification_settings'));
});

// Setting Module
Breadcrumbs::for('social-login-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.social_login_settings'));
});

// Setting Module
Breadcrumbs::for('otp-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.otp_settings'));
});

// Setting Module
Breadcrumbs::for('homepage-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.homepage_settings'));
});

// Setting Module
Breadcrumbs::for('social-setting', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.social_settings'));
});

Breadcrumbs::for('ratings', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.ratings'));
});

Breadcrumbs::for('subscriptions', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.billing_details'), route('admin.subscriptions.index'));
});

Breadcrumbs::for('subscriptions/cancel', function ( $trail) {
    $trail->parent('subscriptions');
    $trail->push(trans('validation.attributes.cancel'));
});

Breadcrumbs::for('subscriptions/resume', function ( $trail) {
    $trail->parent('subscriptions');
    $trail->push(trans('validation.attributes.resume'));
});

Breadcrumbs::for('subscriptions/swap', function ( $trail) {
    $trail->parent('subscriptions');
    $trail->push(trans('validation.attributes.swap'));
});
Breadcrumbs::for('subscriptions/coupon', function ( $trail) {
    $trail->parent('subscriptions');
    $trail->push(trans('validation.attributes.coupon'));
});
Breadcrumbs::for('subscriptions/card', function ( $trail) {
    $trail->parent('subscriptions');
    $trail->push(trans('validation.attributes.card'));
});
Breadcrumbs::for('subscriptions/invoices', function ( $trail) {
    $trail->parent('subscriptions');
    $trail->push(trans('validation.attributes.invoices'));
});
Breadcrumbs::for('subscribers', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.subscribers'));
});

// Dashboard / tables
Breadcrumbs::for('tables', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.tables'), route('admin.tables.index'));
});

// Dashboard / tables / Add
Breadcrumbs::for('tables/add', function ( $trail) {
    $trail->parent('tables');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / tables / Edit
Breadcrumbs::for('tables/edit', function ( $trail) {
    $trail->parent('tables');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / tables / View
Breadcrumbs::for('tables/view', function ( $trail) {
    $trail->parent('tables');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / time-slots
Breadcrumbs::for('time-slots', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.time-slots'), route('admin.time-slots.index'));
});

// Dashboard / time-slots / Add
Breadcrumbs::for('time-slots/add', function ( $trail) {
    $trail->parent('time-slots');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / time-slots / Edit
Breadcrumbs::for('time-slots/edit', function ( $trail) {
    $trail->parent('time-slots');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / time-slots / View
Breadcrumbs::for('time-slots/view', function ( $trail) {
    $trail->parent('time-slots');
    $trail->push(trans('validation.attributes.view'));
});


// Dashboard / addons
Breadcrumbs::for('addons', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.addons'), route('admin.addons.index'));
});

// Dashboard / addons / Add
Breadcrumbs::for('addons/add', function ( $trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / addons / Edit
Breadcrumbs::for('addons/edit', function ( $trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / addons / View
Breadcrumbs::for('addons/view', function ( $trail) {
    $trail->parent('addons');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / bank
Breadcrumbs::for('bank', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.bank'), route('admin.bank.index'));
});

// Dashboard / bank / Add
Breadcrumbs::for('bank/add', function ( $trail) {
    $trail->parent('bank');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / bank / Edit
Breadcrumbs::for('bank/edit', function ( $trail) {
    $trail->parent('bank');
    $trail->push(trans('validation.attributes.edit'));
});
Breadcrumbs::for('bank/show', function ( $trail) {
    $trail->parent('bank');
    $trail->push(trans('validation.attributes.view'));
});

// Dashboard / language
Breadcrumbs::for('language', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.language'), route('admin.language.index'));
});

// Dashboard / language / Add
Breadcrumbs::for('language/add', function ( $trail) {
    $trail->parent('language');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / language / Edit
Breadcrumbs::for('language/edit', function ( $trail) {
    $trail->parent('language');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / push-notifications
Breadcrumbs::for('push-notification', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.push-notification'), route('admin.push-notification.index'));
});

// Dashboard / push-notifications / Add
Breadcrumbs::for('push-notification/add', function ($trail) {
    $trail->parent('push-notification');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / push-notifications / Edit
Breadcrumbs::for('push-notification/edit', function ($trail) {
    $trail->parent('push-notification');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / Update Log
Breadcrumbs::for('update-log', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.update-log'));
});

// Dashboard / User
Breadcrumbs::for('user', function ( $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('validation.attributes.user'), route('admin.user.index'));
});

// Dashboard / user / add
Breadcrumbs::for('user/add', function ( $trail) {
    $trail->parent('user');
    $trail->push(trans('validation.attributes.add'));
});

// Dashboard / delivery boys / Edit
Breadcrumbs::for('user/edit', function ( $trail) {
    $trail->parent('user');
    $trail->push(trans('validation.attributes.edit'));
});

// Dashboard / delivery boys / view
Breadcrumbs::for('user/view', function ( $trail) {
    $trail->parent('user');
    $trail->push(trans('validation.attributes.view'));
});