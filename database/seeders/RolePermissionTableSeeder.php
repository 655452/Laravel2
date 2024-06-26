<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::find(UserRole::ADMIN);
        if (!blank($role)) {
            $ownerBlockedPermission[]['name'] = 'qr-code';
            $ownerBlockedPermission[]['name'] = 'order-notification';
            $ownerBlockedPermission[]['name'] = 'live-orders';
            $role->givePermissionTo(Permission::whereNotIn('name', $ownerBlockedPermission)->get());
        }

        $role = Role::find(UserRole::RESTAURANTOWNER);
        if (!blank($role)) {
            $restaurantOwnerPermission[]['name'] = 'dashboard';
            $restaurantOwnerPermission[]['name'] = 'category';
            $restaurantOwnerPermission[]['name'] = 'category_create';
            $restaurantOwnerPermission[]['name'] = 'category_edit';
            $restaurantOwnerPermission[]['name'] = 'category_delete';
            $restaurantOwnerPermission[]['name'] = 'menu-items';
            $restaurantOwnerPermission[]['name'] = 'menu-items_create';
            $restaurantOwnerPermission[]['name'] = 'menu-items_edit';
            $restaurantOwnerPermission[]['name'] = 'menu-items_delete';
            $restaurantOwnerPermission[]['name'] = 'menu-items_show';
            $restaurantOwnerPermission[]['name'] = 'reservation';
            $restaurantOwnerPermission[]['name'] = 'reservation_create';
            $restaurantOwnerPermission[]['name'] = 'reservation_edit';
            $restaurantOwnerPermission[]['name'] = 'reservation_delete';
            $restaurantOwnerPermission[]['name'] = 'reservation_show';

            $restaurantOwnerPermission[]['name'] = 'coupon';
            $restaurantOwnerPermission[]['name'] = 'coupon_create';
            $restaurantOwnerPermission[]['name'] = 'coupon_edit';
            $restaurantOwnerPermission[]['name'] = 'coupon_show';
            $restaurantOwnerPermission[]['name'] = 'coupon_delete';

            $restaurantOwnerPermission[]['name'] = 'cuisine';
            $restaurantOwnerPermission[]['name'] = 'cuisine_create';
            $restaurantOwnerPermission[]['name'] = 'cuisine_edit';
            $restaurantOwnerPermission[]['name'] = 'cuisine_delete';
            $restaurantOwnerPermission[]['name'] = 'restaurants';
            $restaurantOwnerPermission[]['name'] = 'restaurants_show';
            $restaurantOwnerPermission[]['name'] = 'reservation';
            $restaurantOwnerPermission[]['name'] = 'reservation_create';
            $restaurantOwnerPermission[]['name'] = 'reservation_edit';
            $restaurantOwnerPermission[]['name'] = 'reservation_delete';
            $restaurantOwnerPermission[]['name'] = 'orders';
            $restaurantOwnerPermission[]['name'] = 'orders_create';
            $restaurantOwnerPermission[]['name'] = 'orders_edit';
            $restaurantOwnerPermission[]['name'] = 'orders_delete';
            $restaurantOwnerPermission[]['name'] = 'orders_show';
            $restaurantOwnerPermission[]['name'] = 'live-orders';

            $restaurantOwnerPermission[]['name'] = 'rating';
            $restaurantOwnerPermission[]['name'] = 'request-withdraw';
            $restaurantOwnerPermission[]['name'] = 'request-withdraw_create';
            $restaurantOwnerPermission[]['name'] = 'request-withdraw_edit';
            $restaurantOwnerPermission[]['name'] = 'withdraw';
            $restaurantOwnerPermission[]['name'] = 'qr-code';
            $restaurantOwnerPermission[]['name'] = 'transaction';
            $restaurantOwnerPermission[]['name'] = 'restaurant-owner-sales-report';
            $restaurantOwnerPermission[]['name'] = 'time-slots';
            $restaurantOwnerPermission[]['name'] = 'time-slots_create';
            $restaurantOwnerPermission[]['name'] = 'time-slots_edit';
            $restaurantOwnerPermission[]['name'] = 'time-slots_delete';
            $restaurantOwnerPermission[]['name'] = 'time-slots_show';
            $restaurantOwnerPermission[]['name'] = 'tables';
            $restaurantOwnerPermission[]['name'] = 'tables_create';
            $restaurantOwnerPermission[]['name'] = 'tables_edit';
            $restaurantOwnerPermission[]['name'] = 'tables_delete';
            $restaurantOwnerPermission[]['name'] = 'tables_show';

            $restaurantOwnerPermission[]['name'] = 'banner';
            $restaurantOwnerPermission[]['name'] = 'banner_create';
            $restaurantOwnerPermission[]['name'] = 'banner_edit';
            $restaurantOwnerPermission[]['name'] = 'banner_delete';
            $restaurantOwnerPermission[]['name'] = 'banner_show';

            $permissions                         = Permission::whereIn('name', $restaurantOwnerPermission)->get();
            $role->givePermissionTo($permissions);
        }

        $role = Role::find(UserRole::DELIVERYBOY);
        if (!blank($role)) {
            $deliveryBoyPermission[]['name'] = 'dashboard';
            $deliveryBoyPermission[]['name'] = 'orders';
            $deliveryBoyPermission[]['name'] = 'orders_edit';
            $deliveryBoyPermission[]['name'] = 'orders_show';
            $deliveryBoyPermission[]['name'] = 'order-notification';
            $deliveryBoyPermission[]['name'] = 'request-withdraw';
            $deliveryBoyPermission[]['name'] = 'request-withdraw_create';
            $deliveryBoyPermission[]['name'] = 'request-withdraw_edit';
            $deliveryBoyPermission[]['name'] = 'withdraw';
            $deliveryBoyPermission[]['name'] = 'transaction';
            $permissions                     = Permission::whereIn('name', $deliveryBoyPermission)->get();
            $role->givePermissionTo($permissions);
        }
    }
}
