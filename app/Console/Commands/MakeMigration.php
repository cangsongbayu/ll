<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-migration {model} {--path= : 迁移文件路径}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '根据模型名称生成迁移文件';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $modelName = $this->argument('model');
        $tableName = Str::snake(Str::pluralStudly($modelName));
        $migrationName = "create_{$tableName}_table";

        $path = $this->option('path');

        $this->call('make:migration', [
            'name' => $migrationName,
            '--create' => $tableName,
            '--path' => "database/migrations/{$path}",
        ]);
    }
}
