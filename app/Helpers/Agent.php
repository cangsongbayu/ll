<?php

namespace App\Helpers;

use Jenssegers\Agent\Agent as JAgent;

class Agent
{
    protected static ?JAgent $agent = null;

    protected static function getAgent(): JAgent
    {
        if (!self::$agent) {
            self::$agent = new JAgent();
        }
        return self::$agent;
    }

    public static function getAgentInfo($extends = []): array
    {
        self::getAgent();
        $request = request();
        // 获取设备信息
        $device = self::$agent->device();
        // 获取操作系统信息
        $platform = self::$agent->platform();
        $platformVersion = self::$agent->version($platform);
        // 获取浏览器信息
        $browser = self::$agent->browser();
        $browserVersion = self::$agent->version($browser);
        // 获取 IP 信息
        $ip = $request->ip();
        $ipLocation = IP::getString($ip);
        return [
            'user_agent' => $request->userAgent(),
            'device' => $device,
            'platform' => $platform,
            'platform_version' => $platformVersion,
            'browser' => $browser,
            'browser_version' => $browserVersion,
            'ip' => $ip,
            'ip_location' => $ipLocation,
            ...$extends,
        ];
    }
}
