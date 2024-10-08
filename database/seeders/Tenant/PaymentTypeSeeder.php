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
        $list = [
            [
                'name' => '测试1',
                'slug' => 'test1',
                'valid_amount' => 100,
                'order_ttl' => 120,
                'business_hours' => '00:00:00~23:59:59',
                'is_open_for_business' => 1,
            ],
            [
                'name' => '测试2',
                'slug' => 'test2',
                'valid_amount' => 100,
                'order_ttl' => 120,
                'business_hours' => '00:00:00~23:59:59',
                'is_open_for_business' => 1,
            ]
        ];

        foreach ($list as $item) {
            PaymentType::create($item);
        }
    }
}
