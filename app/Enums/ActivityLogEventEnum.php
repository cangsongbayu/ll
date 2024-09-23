<?php

namespace App\Enums;

enum ActivityLogEventEnum: string
{
    case LOGIN_SUCCESS = 'login_success';
    case LOGIN_FAILURE = 'login_failure';
    case LOGOUT = 'logout';
    case CREATED = 'created';

    public function getActivityLogDescription(?string $details = null): string
    {
        return match ($this) {
            self::LOGIN_SUCCESS => '登录成功',
            self::LOGIN_FAILURE => $details ?? '登录失败',
            self::LOGOUT => '退出登录',
            default => '未知事件',
        };
    }

    public static function getLoginFailureDescription(string $reason): string
    {
        return match ($reason) {
            'USERNAME_NOT_FOUND' => '登录失败，用户名不存在',
            'PASSWORD_INCORRECT' => '登录失败，密码错误',
            'TFA_CODE_INCORRECT' => '登录失败，动态密码错误',
        };
    }
}
