<?php

namespace App\Models\Filters;

/**
 * @method whereLike(string $string, $value)
 */
class CurrencyFilter extends BaseModelFilter
{
    public function name($value): void
    {
        $this->whereLike('name', $value);
    }

    public function code($value): void
    {
        $this->where('code', $value);
    }

    public function symbol($value): void
    {
        $this->where('symbol', $value);
    }

    public function isBaseCurrency($value): void
    {
        $this->where('is_base_currency', intval($value));
    }
}
