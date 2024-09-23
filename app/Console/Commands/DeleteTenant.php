<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

class DeleteTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-tenant {--select : 选择模式}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除租户';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $tenants = Tenant::all()->keyBy('id');

        if ($tenants->isEmpty()) {
            $this->error('没有可删除的租户');
            return;
        }

        $options = $tenants->mapWithKeys(fn($tenant) => [$tenant->id => $tenant->name]);

        $index = $this->choice(
            '请选择要删除的租户',
            $options->toArray(),
            -1,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );

        if ($index != -1) {
            $tenant = $tenants[$index];
            $tenant->delete();
            $this->info("租户已删除：{$tenant->name}");
        }
    }
}
