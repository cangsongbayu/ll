<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            $arr = [
                'name' => "agent$i",
                'username' => "agent$i",
                'password' => '123',
            ];
            Agent::create($arr);
        }
    }
}
