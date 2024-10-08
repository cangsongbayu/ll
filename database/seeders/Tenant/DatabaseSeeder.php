<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            CurrencySeeder::class,
            UserSeeder::class,
            AgentSeeder::class,
            MerchantSeeder::class,
            PaymentTypeSeeder::class,
            MerchantRateSeeder::class,
            SupplierSeeder::class,
        ]);
    }
}
