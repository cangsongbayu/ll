<?php

namespace Database\Seeders\Tenant;

use App\Enums\SettingCategoryEnum;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $list = [
            [
                'category' => SettingCategoryEnum::GENERAL,
                'key' => 'allowed_depositable_types',
                'value' => 'merchant,supplier',
                'description' => '押金主体类型',
            ]
        ];

        foreach ($list as $item) {
            Setting::create($item);
        }
    }
}
