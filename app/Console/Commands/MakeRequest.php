<?php

namespace App\Console\Commands;

use Doctrine\DBAL\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Console\RequestMakeCommand;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MakeRequest extends RequestMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-request {name} {--connection=mysql : 连接} {--model= : 模型} {--action=store : 操作}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成表单请求类文件';

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/request.app.stub');
    }

    /**
     * @throws FileNotFoundException
     * @throws Exception
     */
    protected function buildClass($name): string
    {
        return $this->replaceRouteModel($this->replaceRules(parent::buildClass($name)));
    }

    /**
     * Replace the rules for the given stub.
     *
     * @param string $stub
     * @return string
     * @throws Exception
     */
    protected function replaceRules(string $stub): string
    {
        $action = $this->option('action');
        $rules = $this->generateRules($action);
        return str_replace('{{ rules }}', $rules, $stub);
    }

    protected function replaceRouteModel(string $stub): string
    {
        $action = $this->option('action');
        $modelName = $this->option('model');
        $modelVariableName = Str::camel($modelName);
        if ($action === 'update') {
            $code = '$' . $modelVariableName . ' = ' . '$this->route(' . "'$modelVariableName'" . ');' . "\n";
            return str_replace('{{ routeModel }}', $code, $stub);
        } else {
            // 删除包含 {{ routeModel }} 的整行，同时调整 return 的缩进
            $stub = preg_replace('/^\s*{{ routeModel }}\s*\n?/m', '', $stub);
            // 修正 return 的缩进
            return preg_replace('/^return/m', '        return', $stub);
        }
    }

    /**
     * @throws Exception
     */
    public function generateRules(string $action): string
    {
        $rules = [];
        if ($action === 'index') {
            $rules['config(\'app.page_size_name\')'] = [
                'integer',
                '\'between:1,\'' . ' . ' . 'config(\'app.max_page_size\')',
            ];
            $rules['config(\'app.page_name\')'] = [
                'integer',
                'min:1',
            ];
        } else if (in_array($action, ['store', 'update'])) {
            $connection = $this->option('connection');
            $schemaManager = Schema::connection($connection)
                ->getConnection()
                ->getDoctrineSchemaManager();
            $modelName = $this->option('model');
            $modelClass = "App\\Models\\$modelName";
            $modelVariableName = Str::camel($modelName);
            $tableName = $this->getTableName($modelClass);
            $columns = $schemaManager->listTableColumns($tableName);
            $indexes = $schemaManager->listTableIndexes($tableName);

            foreach ($columns as $column) {
                $rule = [];
                // 忽略主键、自增字段
                $ignore = ['id', 'created_at', 'updated_at', 'deleted_at'];
                if ($column->getAutoincrement() || in_array($column->getName(), $ignore)) {
                    continue;
                }
                // 检查是否有唯一索引
                $isUnique = false;
                foreach ($indexes as $index) {
                    if ($index->isUnique() && count($index->getColumns()) === 1 && $index->getColumns()[0] === $column->getName()) {
                        $isUnique = true;
                        break;
                    }
                }
                if ($isUnique) {
                    $rule[] = $action === 'store'
                        ? 'unique:' . $modelClass . ',' . $column->getName()
                        : "\"" . 'unique:' . $modelClass . ',' . $column->getName() . ',' . $modelVariableName . '->id' . "\"";
                }
                // 是否允许为空
                $rule[] = $column->getNotnull() ? ($action === 'store' ? 'required' : 'filled') : 'nullable';
                // 类型
                $type = $column->getType()->getName();
                // 字符串
                if ($type === 'string') {
                    $length = $column->getLength();
                    $rule[] = 'string';
                    $rule[] = "max:$length";
                } else if ($type === 'text') {
                    $rule[] = 'string';
                } else if (in_array($type, ['smallint', 'integer'])) {
                    $rule[] = 'integer';
                    $rule[] = "db_{$type}" . ($column->getUnsigned() ? ':unsigned' : '');
                } else if ($type === 'bigint') {
                    $rule[] = 'numeric';
                    $rule[] = "db_{$type}" . ($column->getUnsigned() ? ':unsigned' : '');
                } else if ($type === 'boolean') {
                    $rule[] = 'boolean';
                } else if ($type === 'decimal') {
                    $precision = $column->getPrecision();
                    $scale = $column->getScale();
                    $rule[] = 'numeric';
                    $rule[] = "decimal:{$scale}";
                    $rule[] = "db_decimal:{$precision},{$scale}";
                }
                $rules[$column->getName()] = $rule;
            }
        }

        return $this->rulesToCodeString($rules);
    }

    private function rulesToCodeString(array $rules): string
    {
        $formattedRules = [];
        foreach ($rules as $field => $fieldRules) {
            $fieldName = $this->formatFieldName($field);
            $formattedRules[] = "            $fieldName => [";
            foreach ($fieldRules as $rule) {
                if (str_contains($rule, 'config(')) {
                    // 对于包含 config() 或特殊字符串连接的规则，不用引号包裹
                    $formattedRules[] = "                $rule,";
                } else {
                    $formattedRules[] = "                '$rule',";
                }
            }
            $formattedRules[] = "            ],";
        }

        return implode("\n", $formattedRules);
    }

    private function formatFieldName($field): string
    {
        if (str_contains($field, 'config(')) {
            // 如果字段名包含 config()，直接返回不加引号
            return $field;
        } elseif (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $field)) {
            // 如果字段名是有效的 PHP 变量名，使用单引号
            return "'$field'";
        } else {
            // 其他情况，使用双引号以支持变量插值
            return "\"$field\"";
        }
    }

    public function getTableName($modelClass)
    {
        if (!class_exists($modelClass)) {
            $this->error("模型 $modelClass 不存在");
            exit(1);
        }
        return (new $modelClass)->getTable();
    }
}
