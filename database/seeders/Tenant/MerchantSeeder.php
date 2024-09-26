<?php

namespace Database\Seeders\Tenant;

use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            $arr = [
                'name' => "merchant$i",
                'username' => "merchant$i",
                'password' => '123',
            ];
            Merchant::create($arr);
        }
    }
}
