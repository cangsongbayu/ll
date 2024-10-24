<?php

namespace Database\Seeders\Tenant;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $list = [
            [
                'name' => 'postman',
                'username' => 'postman',
                'password' => '123',
            ],
            [
                'name' => 'zz',
                'username' => 'zz',
                'password' => '123',
            ],
            [
                'name' => 'ywn',
                'username' => 'ywn',
                'password' => '123',
            ],
            [
                'name' => 'ds',
                'username' => 'ds',
                'password' => '123',
            ],
            [
                'name' => 'zt',
                'username' => 'zt',
                'password' => '123'
            ]
        ];

        foreach ($list as $item) {
            User::create($item);
        }
    }
}
