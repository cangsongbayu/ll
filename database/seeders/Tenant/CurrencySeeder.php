<?php

namespace Database\Seeders\Tenant;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $list = [
            [
                'code' => 'USD',
                'name' => '美元',
                'symbol' => '$',
                'is_base_currency' => false,
            ],
            [
                'code' => 'CNY',
                'name' => '人民币',
                'symbol' => '¥',
                'is_base_currency' => true,
            ]
        ];

        foreach ($list as $item) {
            Currency::create($item);
        }
    }
}
