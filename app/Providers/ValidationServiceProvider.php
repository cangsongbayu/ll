<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Validator::extend('db_tinyint', function ($attribute, $value, $parameters, $validator) {
            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? 0 : -128;
            $max = $unsigned ? 255 : 127;
            return is_numeric($value) && $validator->validateBetween($attribute, $value, [$min, $max]);
        });

        Validator::replacer('db_tinyint', function ($message, $attribute, $rule, $parameters) {
            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? 0 : -128;
            $max = $unsigned ? 255 : 127;
            return str_replace([':min', ':max'], [$min, $max], $message);
        });

        Validator::extend('db_smallint', function ($attribute, $value, $parameters, $validator) {
            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? 0 : -32768;
            $max = $unsigned ? 65535 : 32767;
            return is_numeric($value) && $validator->validateBetween($attribute, $value, [$min, $max]);
        });

        Validator::replacer('db_smallint', function ($message, $attribute, $rule, $parameters) {
            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? 0 : -32768;
            $max = $unsigned ? 65535 : 32767;
            return str_replace([':min', ':max'], [$min, $max], $message);
        });

        Validator::extend('db_integer', function ($attribute, $value, $parameters, $validator) {
            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? 0 : -2147483648;
            $max = $unsigned ? 4294967295 : 2147483647;
            return is_numeric($value) && $validator->validateBetween($attribute, $value, [$min, $max]);
        });

        Validator::replacer('db_integer', function ($message, $attribute, $rule, $parameters) {
            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? 0 : -2147483648;
            $max = $unsigned ? 4294967295 : 2147483647;
            return str_replace([':min', ':max'], [$min, $max], $message);
        });

        Validator::extend('db_bigint', function ($attribute, $value, $parameters, $validator) {
            // 检查是否为有效的数字
            if (!is_numeric($value)) {
                return false;
            }

            // 将输入转换为字符串，保持原始精度
            $value = (string)$value;

            // 如果是科学记数法，转换为普通数字字符串
            if (stripos($value, 'e') !== false) {
                $value = sprintf('%.0f', $value);
            }

            // 检查是否包含小数点，如果包含则验证失败
            if (str_contains($value, '.')) {
                return false;
            }

            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? '0' : '-9223372036854775808';
            $max = $unsigned ? '18446744073709551615' : '9223372036854775807';

            if (!$validator->validateBetween($attribute, $value, [$min, $max])) {
                return false;
            }
            return true;
        });

        Validator::replacer('db_bigint', function ($message, $attribute, $rule, $parameters) {
            $unsigned = isset($parameters[0]) && $parameters[0] === 'unsigned';
            $min = $unsigned ? '0' : '-9223372036854775808';
            $max = $unsigned ? '18446744073709551615' : '9223372036854775807';
            return str_replace([':min', ':max'], [$min, $max], $message);
        });

        Validator::extend('db_decimal', function ($attribute, $value, $parameters, $validator) {
            $precision = (int)$parameters[0];
            $scale = (int)$parameters[1];
            $unsigned = isset($parameters[2]) && $parameters[2] === 'unsigned';
            [$min, $max] = $this->calculateDecimalRange($precision, $scale, $unsigned);
            return $validator->validateBetween($attribute, $value, [$min, $max]);
        });

        Validator::replacer('db_decimal', function ($message, $attribute, $rule, $parameters) {
            $precision = (int)$parameters[0];
            $scale = (int)$parameters[1];
            $unsigned = isset($parameters[2]) && $parameters[2] === 'unsigned';
            [$min, $max] = $this->calculateDecimalRange($precision, $scale, $unsigned);
            return str_replace([':min', ':max'], [$min, $max], $message);
        });
    }

    // 辅助函数，用于计算 decimal 的最小值和最大值
    function calculateDecimalRange($precision, $scale, $unsigned = false): array
    {
        $maxIntegerDigits = $precision - $scale;
        $max = str_repeat('9', $maxIntegerDigits) . ($scale > 0 ? '.' . str_repeat('9', $scale) : '');
        $min = $unsigned ? '0' : '-' . $max;
        return [$min, $max];
    }
}
