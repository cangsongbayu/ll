<?php

namespace App\Enums;

enum ActivityLogNameEnum: string
{
    case LOGIN = 'login'; // 登录
    case USER = 'user'; // 用户
}
