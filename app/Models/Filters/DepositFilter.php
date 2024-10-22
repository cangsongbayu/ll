<?php

namespace App\Models\Filters;

class DepositFilter extends BaseModelFilter
{
    public function tradeNo($value): void
    {
        $this->where('trade_no', $value);
    }

    public function depositableType($value): void
    {
        $this->where('depositable_type', $value);
    }
}
