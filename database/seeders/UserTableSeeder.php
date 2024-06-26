<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        User::create([
            "first_name"        => "John",
            "last_name"         => "Doe",
            "email"             => "admin@example.com",
            "username"          => "admin",
            "email_verified_at" => null,
            'password'          => bcrypt('123456'),
            "phone"             => "115005550006",
            'country_code'      => "880",
            'country_code_name' => "bd",
            "address"           => "Dhaka, Bangladesh",
            "balance_id"        => 1,
            "device_token"      => null,
            "web_token"         => "f55yNKE9A",
            "status"            => 5,
            "applied"           => 10,
            "last_login_at"     => null,
            'remember_token'    => Str::random(10),
        ]);

        $user = User::create([
            "first_name"        => "Jack J.",
            "last_name"         => "Smith",
            "email"             => "customer@example.com",
            "username"          => "customer",
            "email_verified_at" => null,
            'password'       => bcrypt('123456'),
            "phone"             => "115675675657",
            'country_code'      => "880",
            'country_code_name' => "bd",
            "address"           => "Dhaka, Bangladesh",
            "balance_id"        => 2,
            "device_token"      => null,
            "web_token"         => null,
            "status"            => 5,
            "applied"           => 10,
            "last_login_at"     => null,
            'remember_token'    => Str::random(10),
        ]);
        $role    = Role::find(2);
        $user->assignRole($role->name);

        $user3 = User::create([
            "first_name"        => "Richard P.",
            "last_name"         => "Gonzales",
            "email"             => "restaurantowner1@example.com",
            "username"          => "restaurantowner1",
            "email_verified_at" => null,
            'password'       => bcrypt('123456'),
            "phone"             => "453457567567",
            'country_code'      => "880",
            'country_code_name' => "bd",
            "address"           => "1250 W 72nd St, New York, United State",
            "balance_id"        => 2,
            "device_token"      => null,
            "web_token"         => null,
            "status"            => 5,
            "applied"           => 10,
            "last_login_at"     => null,
            'remember_token'    => Str::random(10),
        ]);
        $role3     = Role::find(3);
        $user3->assignRole($role3->name);

        $user4 = User::create([
            "first_name"        => "Fabian C.",
            "last_name"         => "Williams",
            "email"             => "deliveryboy@example.com",
            "username"          => "delivery",
            "email_verified_at" => null,
            'password'          => bcrypt('123456'),
            "phone"             => "15005550007",
            'country_code'      => "880",
            'country_code_name' => "bd",
            "address"           => "Dhaka, Bangladesh",
            "balance_id"        => 4,
            "device_token"      => null,
            "web_token"         => null,
            "status"            => 5,
            "applied"           => 10,
            "last_login_at"     => null,
            'remember_token'    => Str::random(10),
        ]);
        $role4     = Role::find(4);
        $user4->assignRole($role4->name);

        $user5 = User::create([
            "first_name"        => "Waiter",
            "last_name"         => "Waiter",
            "email"             => "waiter@example.com",
            "username"          => "waiter",
            "email_verified_at" => null,
            'password'          => bcrypt('123456'),
            "phone"             => "15005550007",
            'country_code'      => "880",
            'country_code_name' => "bd",
            "address"           => "Dhaka, Bangladesh",
            "balance_id"        => 5,
            "device_token"      => null,
            "web_token"         => null,
            "status"            => 5,
            "applied"           => 10,
            "last_login_at"     => null,
            'remember_token'    => Str::random(10),
        ]);
        $role5    = Role::find(5);
        $user5->assignRole($role5->name);

        if (env('DEMO_MODE')) {
            $user6 = User::create([
                "first_name"        => "Delivery Boy",
                "last_name"         => "Two",
                "email"             => "deliveryboy2@example.com",
                "username"          => "delivery2",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role6     = Role::find(4);
            $user6->assignRole($role6->name);

            $user7 = User::create([
                "first_name"        => "restaurant",
                "last_name"         => "owner",
                "email"             => "restaurantowner@example.com",
                "username"          => "restaurantowner",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role7     = Role::find(3);
            $user7->assignRole($role7->name);

            $user8 = User::create([
                "first_name"        => "restaurant",
                "last_name"         => "owner",
                "email"             => "restaurantowner3@example.com",
                "username"          => "restaurantowner3",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role8   = Role::find(3);
            $user8->assignRole($role8->name);

            $user9 = User::create([
                "first_name"        => "restaurant",
                "last_name"         => "owner",
                "email"             => "restaurantowner4@example.com",
                "username"          => "restaurantowner4",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role9     = Role::find(3);
            $user9->assignRole($role9->name);

            $user10 = User::create([
                "first_name"        => "restaurant",
                "last_name"         => "owner",
                "email"             => "restaurantowner5@example.com",
                "username"          => "restaurantowner5",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role10  = Role::find(3);
            $user10->assignRole($role10->name);

            $user11 = User::create([
                "first_name"        => "restaurant",
                "last_name"         => "owner",
                "email"             => "restaurantowner6@example.com",
                "username"          => "restaurantowner6",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role11  = Role::find(3);
            $user11->assignRole($role11->name);

            $user12 = User::create([
                "first_name"        => "Restaurant",
                "last_name"         => "owner",
                "email"             => "restaurantowner7@example.com",
                "username"          => "restaurantowner7",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role12  = Role::find(3);
            $user12->assignRole($role12->name);

            $user13 = User::create([
                "first_name"        => "Restaurant",
                "last_name"         => "owner",
                "email"             => "restaurantowner8@example.com",
                "username"          => "restaurantowner8",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role13  = Role::find(3);
            $user13->assignRole($role13->name);

            $user14 = User::create([
                "first_name"        => "Customer",
                "last_name"         => "Tw",
                "email"             => "customer2@example.com",
                "username"          => "customer2",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "115005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 1,
                "device_token"      => null,
                "web_token"         => "f55yNKE9A",
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role14 = Role::find(3);
            $user14->assignRole($role14->name);

            $user15 = User::create([
                "first_name"        => "Waiter2",
                "last_name"         => "Waiter2",
                "email"             => "waiter2@example.com",
                "username"          => "waiter2",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "15005550002",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 5,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role15 = Role::find(5);
            $user15->assignRole($role15->name);

            $user16 = User::create([
                "first_name"        => "Waiter3",
                "last_name"         => "Waiter3",
                "email"             => "waiter3@example.com",
                "username"          => "waiter3",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "15005550003",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 5,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role16 = Role::find(5);
            $user16->assignRole($role16->name);

            $user17 = User::create([
                "first_name"        => "Waiter4",
                "last_name"         => "Waiter4",
                "email"             => "waiter4@example.com",
                "username"          => "waiter4",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "15005550004",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 5,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role17 = Role::find(5);
            $user17->assignRole($role17->name);

            $user18 = User::create([
                "first_name"        => "Waiter5",
                "last_name"         => "Waiter5",
                "email"             => "waiter5@example.com",
                "username"          => "waiter5",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "15005550005",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 5,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role18 = Role::find(5);
            $user18->assignRole($role18->name);

            $user19 = User::create([
                "first_name"        => "Waiter6",
                "last_name"         => "Waiter6",
                "email"             => "waiter6@example.com",
                "username"          => "waiter6",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "15005550006",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 5,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role19 = Role::find(5);
            $user19->assignRole($role19->name);

            $user20 = User::create([
                "first_name"        => "Waiter7",
                "last_name"         => "Waiter7",
                "email"             => "waiter7@example.com",
                "username"          => "waiter7",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "15005550007",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 5,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role20 = Role::find(5);
            $user20->assignRole($role20->name);

            $user21 = User::create([
                "first_name"        => "Waiter8",
                "last_name"         => "Waiter8",
                "email"             => "waiter8@example.com",
                "username"          => "waiter8",
                "email_verified_at" => null,
                'password'          => bcrypt('123456'),
                "phone"             => "15005550008",
                'country_code'      => "880",
                'country_code_name' => "bd",
                "address"           => "Dhaka, Bangladesh",
                "balance_id"        => 5,
                "device_token"      => null,
                "web_token"         => null,
                "status"            => 5,
                "applied"           => 10,
                "last_login_at"     => null,
                'remember_token'    => Str::random(10),
            ]);
            $role21 = Role::find(5);
            $user21->assignRole($role21->name);
        }
    }
}
 