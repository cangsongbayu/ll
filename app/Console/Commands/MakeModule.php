<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-module {name} {--connection=mysql : 连接}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成一个模块';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $name = $this->argument('name');
        $table = Str::snake(Str::pluralStudly($name));
        $connection = $this->option('connection');

        $this->call('code:models', [
            '--table' => $table,
            '--connection' => $connection
        ]);
        $this->call('model:filter', [
            'name' => $name,
        ]);
        $this->call('make:resource', [
            'name' => $name,
        ]);
        $this->call('make:resource', [
            'name' => $name . 'Collection'
        ]);
        $actions = ['store', 'update', 'destroy', 'index'];
        foreach ($actions as $action) {
            $this->call('app:make-request', [
                'name' => $name . '/' . ucwords($action) . 'Request' ,
                '--connection' => $connection,
                '--model' => $name,
                '--action' => $action,
            ]);
        }
        $this->call('app:make-service', [
            'name' => $name,
        ]);
        $this->call('make:controller', [
            'name' => $name . 'Controller',
            '--api' => true,
            '--model' => $name,
        ]);
    }
}
