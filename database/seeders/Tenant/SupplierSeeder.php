<?php

namespace Database\Seeders\Tenant;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            $arr = [
                'name' => "supplier$i",
                'username' => "supplier$i",
                'password' => '123',
            ];
            Supplier::create($arr);
        }
    }
}
