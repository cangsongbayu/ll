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
        $list = json_decode(file_get_contents(base_path('json/currencies.json')), true);
        foreach ($list as $item) {
            Currency::create($item);
        }
    }
}
