<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成服务类文件';

    /**
     * 文件系统类
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * 需要替换的占位符
     *
     * @var array|string[]
     */
    protected array $search = [
        '{{ class }}',
        '{{ model }}',
        '{{ modelVariable }}'
    ];

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    protected function getStub(): string
    {
        return base_path('/stubs/service.stub');
    }

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        //
        $fileName = $this->argument('name');
        $path = app_path("Services/{$fileName}.php");

        if (!$this->filesystem->exists(app_path('Services'))) {
            $this->filesystem->makeDirectory(app_path('Services'));
        }

        $stub = $this->filesystem->get($this->getStub());
        // 替换占位符
        $name = str_replace('Service', '', $fileName);
        $class = $fileName;
        $model = $name;
        $modelVariable = Str::camel($name);
        $stub = str_replace($this->search, [
            $class,
            $model,
            $modelVariable
        ], $stub);
        $this->filesystem->put($path, $stub);
    }
}
