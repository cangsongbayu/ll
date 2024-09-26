<?php

namespace App\Helpers;

class OrderNumberGenerator
{
    public static function generate($prefix = ''): string
    {
        return $prefix . mt_rand(100000000000, 999999999999);
    }
}
