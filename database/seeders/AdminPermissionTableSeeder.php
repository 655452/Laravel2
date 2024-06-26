<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $role = Role::find(1);
        if (!blank($user) && !blank($role)) {
            $user->assignRole($role->name);
        }
            $ownerBlockedPermission[]['name'] = 'qr-code';
            $ownerBlockedPermission[]['name'] = 'order-notification';
            $ownerBlockedPermission[]['name'] = 'live-orders';

        $user->givePermissionTo(Permission::whereNotIn('name', $ownerBlockedPermission)->get());
    }
}
