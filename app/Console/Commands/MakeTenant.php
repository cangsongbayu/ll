<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class MakeTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-tenant {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建租户';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $name = $this->argument('name');
        $tenant = Tenant::create([
            'name' => $name,
        ]);
        $this->info("租户创建成功，ID: {$tenant->id}");
    }
}
