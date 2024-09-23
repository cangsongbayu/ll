<?php

namespace App\Helpers;

class MySQLIntegerRanges
{
    private static array $ranges = [
        'tinyint' => [-128, 127],
        'tinyint_unsigned' => [0, 255],
        'smallint' => [-32768, 32767],
        'smallint_unsigned' => [0, 65535],
        'mediumint' => [-8388608, 8388607],
        'mediumint_unsigned' => [0, 16777215],
        'int' => [-2147483648, 2147483647],
        'int_unsigned' => [0, 4294967295],
        'bigint' => [-9223372036854775808, 9223372036854775807],
        'bigint_unsigned' => [0, 18446744073709551615],
    ];

    public static function getMin($type)
    {
        return self::$ranges[$type][0];
    }

    public static function getMax($type)
    {
        return self::$ranges[$type][1];
    }
}
