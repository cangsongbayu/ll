<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case FAILED = 1;
    case PAYMENT_IN_PROGRESS = 2;
    case PAID = 3;
    case CANCELED = 4;
}
