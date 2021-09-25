<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionRoleSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(AccountAutoPostingTypeSeeder::class);
        $this->call(AccountLevelSeeder::class);
        $this->call(AccountTypeSeeder::class);
        $this->call(ChannelSeeder::class);
        $this->call(CinCoutRuleSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ComplainStatusSeeder::class);
        $this->call(ContactTypeSeeder::class);
        $this->call(DefaultRuleSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(TaxRateSeeder::class);
        $this->call(VoucherTypeSeeder::class);
    }
}
