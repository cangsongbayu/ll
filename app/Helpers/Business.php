<?php

namespace App\Helpers;

class Business
{
    public function isWithinBusinessHours(string $businessHours): bool
    {
        // 将营业时间字符串分割成开始时间和结束时间
        [$startTime, $endTime] = explode('~', $businessHours);

        // 获取当前时间
        $currentTime = date('H:i:s');

        // 如果结束时间小于开始时间,说明跨越了午夜
        if ($endTime < $startTime) {
            return $currentTime >= $startTime || $currentTime <= $endTime;
        }

        // 正常情况,检查当前时间是否在开始时间和结束时间之间
        return $currentTime >= $startTime && $currentTime <= $endTime;
    }

}
