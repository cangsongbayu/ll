<?php

namespace App\Enums;

enum ApiMessageShowTypeEnum: string
{
    case SILENT = 'SILENT'; // 静默
    case WARNING = 'WARNING'; // 警告
    case ERROR = 'ERROR'; // 错误
    case SUCCESS = 'SUCCESS'; // 成功
}
