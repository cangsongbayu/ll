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

    public function depositable($value): void
    {
        $this->where('depositable_id', $value);
    }

    public function currency($value): void
    {
        $this->where('currency_id', $value);
    }

    public function baseCurrency($value): void
    {
        $this->where('base_currency_id', $value);
    }
}
