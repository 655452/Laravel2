<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '1024M');

        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(BackendMenuTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(AdminPermissionTableSeeder::class);

        $this->call(LanguageSeeder::class);
        $this->call(FooterMenuSections::class);
        $this->call(TemplateTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(RestaurantTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(BestSellingCategorySeeder::class);
        $this->call(AddressTableSeeder::class);

        $this->call(OrderTableSeeder::class); // New
        $this->call(OrderHistoryTableSeeder::class);// New
        $this->call(OrderLineItemTableSeeder::class);// New
        $this->call(InvoicesTableSeeder::class);// New

        $this->call(LedgerTableSeeder::class);// New
        $this->call(TransactionsTablesSeeder::class);// New

        $this->call(CouponSeeder::class);
        $this->call(RestaurentRattingSeeder::class);
        $this->call(CuisineTableSeeder::class);
        $this->call(RestaurantCuisinesTableSeeder::class);
        $this->call(TablesSeeder::class);
        $this->call(TimeSlotSeeder::class);

        $this->call(DiscountsSeeder::class);// New

        $this->call(CategoryMenuItemsSeeder::class);
        $this->call(BalancesSeeder::class);
        $this->call(DeliveryStatusHistoriesSeeder::class);
        $this->call(DeliveryBoyAccountsSeeder::class);
        $this->call(ReservationsSeeder::class);
        $this->call(MenuItemVariationsSeeder::class);
        $this->call(MenuItemOptionsSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(WaiterTableSeeder::class);
        $this->call(BannerTableSeeder::class);
        $this->call(DineinOrdersTableSeeder::class);

        $this->call(CollectionTableSeeder::class);// New
        $this->call(RequestWithdrawSeeder::class);// New
        $this->call(WithdrawSeeder::class);// New
        $this->call(BankTableSeeder::class);// New
        $this->call(PushNotificationsSeeder::class);// New

    }
}
