<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            $arr = [
                'name' => "测试$i",
                'slug' => "test$i",
                'valid_amount' => 100,
                'order_ttl' => 120,
                'business_hours' => '00:00:00~23:59:59',
                'is_open_for_business' => 1,
            ];
            PaymentType::create($arr);
        }
    }
}
