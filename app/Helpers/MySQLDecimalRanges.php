<?php

namespace App\Helpers;

class MySQLDecimalRanges
{
    /**
     * @param int $precision 精度
     * @param int $scale 小数位数
     * @return array 最小值和最大值
     */
    public static function getRange(int $precision, int $scale): array
    {
        // 计算整数部分的位数
        $integerDigits = $precision - $scale;
        // 计算最大值和最小值
        $maxValue = str_repeat('9', $integerDigits) . ($scale > 0 ? '.' . str_repeat('9', $scale) : '');
        $minValue = '-' . $maxValue;
        // 转换为浮点数以处理科学记数法
        $maxValue = floatval($maxValue);
        $minValue = floatval($minValue);
        return [$minValue, $maxValue];
    }

    public static function getMin(int $precision, int $scale)
    {
        return self::getRange($precision, $scale)[0];
    }

    public static function getMax(int $precision, int $scale)
    {
        return self::getRange($precision, $scale)[1];
    }
}
