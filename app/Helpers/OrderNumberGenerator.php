<?php

namespace App\Helpers;

class OrderNumberGenerator
{
    public static function generate($prefix = ''): string
    {
        // 获取当前日期信息
        $date = date('ymdHis');
        // 获取一个随机数
        $random = mt_rand(1000, 9999);
        // 组合订单号
        return $prefix . $date . $random;
    }
}
