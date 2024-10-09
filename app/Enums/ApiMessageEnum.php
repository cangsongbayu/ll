<?php

namespace App\Enums;

enum ApiMessageEnum: string
{
    case GENERAL_SUCCESS = 'GENERAL_SUCCESS';
    case UPLOAD_SUCCESS = 'UPLOAD_SUCCESS';
    case LOGIN = 'LOGIN';
    case INDEX = 'INDEX';
    case STORE_OR_UPDATE = 'STORE_OR_UPDATE';
    case DESTROY = 'DESTROY';
    case RESTORE = 'RESTORE';
    case BATCH_DESTROY = 'BATCH_DESTROY';
    case BATCH_RESTORE = 'BATCH_RESTORE';
    case REPASS = 'REPASS';
    case LOGOUT = 'LOGOUT';
    case ENABLE_TFA = 'ENABLE_TFA';
    case DISABLE_TFA = 'DISABLE_TFA';

    public function getMessage(): string
    {
        return match ($this) {
            self::GENERAL_SUCCESS => '成功',
            self::UPLOAD_SUCCESS => '上传成功',
            self::LOGIN => '登录成功',
            self::INDEX => '查询成功',
            self::STORE_OR_UPDATE => '保存成功',
            self::DESTROY => '删除成功',
            self::RESTORE => '恢复成功',
            self::BATCH_DESTROY => '批量删除成功',
            self::BATCH_RESTORE => '批量恢复成功',
            self::REPASS => '密码重置成功，请重新登录',
            self::LOGOUT => '退出登录',
            self::ENABLE_TFA => '双因素认证已开启，请重新登录',
            self::DISABLE_TFA => '双因素认证已关闭，您的账号安全性降低，请谨慎操作',
        };
    }

    public function getMessageWithParams(array $params = []): string
    {
        return match ($this) {
            self::BATCH_DESTROY => __('messages.batch_destroy', $params),
            self::BATCH_RESTORE => __('messages.batch_restore', $params),
            default => $this->getMessage(),
        };
    }
}
