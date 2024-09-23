<?php

namespace App\Helpers;

use Zhuzhichao\IpLocationZh\Ip as IpLocationZh;
use Illuminate\Support\Facades\Cache;

class IP
{
    public static function getString($ip, $cacheSeconds = 86400): string
    {
        return Cache::remember("ip_location_{$ip}", $cacheSeconds, function() use ($ip) {
            $ipLocation = IpLocationZh::find($ip);

            if (!is_array($ipLocation)) {
                return '未知';
            }

            return collect($ipLocation)->filter()->unique()->implode(' ');
        });
    }
}
