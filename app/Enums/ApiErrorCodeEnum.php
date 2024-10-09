<?php

namespace App\Enums;

enum ApiErrorCodeEnum: string
{
    case INVALID_REQUEST = 'INVALID_REQUEST';
    case LOGIN_FAILED = 'LOGIN_FAILED';
    case METHOD_NOT_ALLOWED_HTTP_EXCEPTION = 'METHOD_NOT_ALLOWED_HTTP_EXCEPTION';
    case NOT_FOUND_HTTP_EXCEPTION = 'NOT_FOUND_HTTP_EXCEPTION';
    case VALIDATION_EXCEPTION = 'VALIDATION_EXCEPTION';
    case AUTHENTICATION_EXCEPTION = 'AUTHENTICATION_EXCEPTION';

    public function getErrorMessage(): string
    {
        return match($this) {
            self::INVALID_REQUEST => '无效请求',
            self::LOGIN_FAILED => '登录失败',
            self::METHOD_NOT_ALLOWED_HTTP_EXCEPTION => '请求方法不允许',
            self::NOT_FOUND_HTTP_EXCEPTION => '请求的资源不存在',
            self::VALIDATION_EXCEPTION => '提交的数据有误，请检查',
            self::AUTHENTICATION_EXCEPTION => '未授权',
        };
    }
}
