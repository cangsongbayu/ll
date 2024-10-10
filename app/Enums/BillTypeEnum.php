<?php

namespace App\Enums;

enum BillTypeEnum: int
{
    case ORDER_INCOME = 1;
    case PLATFORM_FEE_PAYMENT = 2;
    case ORDER_PAYMENT_RECEIVED = 3;
    case COMMISSION_INCOME = 4;
    case COMMISSION_RECEIVED = 5;
    case WITHDRAW = 6;
    case REVERSAL = 7;
    case MANUAL_ADJUSTMENT = 8;
    case TRANSFER_IN = 9;
    case TRANSFER_OUT = 10;
    case COMMISSION_TO_BALANCE = 11;

    public function label(): string
    {
        return match($this)
        {
            self::ORDER_INCOME => '订单收入',
            self::PLATFORM_FEE_PAYMENT => '手续费',
            self::ORDER_PAYMENT_RECEIVED => '订单付款接收',
            self::COMMISSION_INCOME => '佣金',
            self::COMMISSION_RECEIVED => '返佣',
            self::WITHDRAW => '提现',
            self::REVERSAL => '冲正',
            self::MANUAL_ADJUSTMENT => '手动调整余额',
            self::TRANSFER_IN => '转账（收）',
            self::TRANSFER_OUT => '转账（付）',
            self::COMMISSION_TO_BALANCE => '佣金转余额',
        };
    }
}
