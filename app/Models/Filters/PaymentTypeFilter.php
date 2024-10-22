<?php

namespace App\Models\Filters;

/**
 * @method whereLike(string $string, $value)
 */
class PaymentTypeFilter extends BaseModelFilter
{
    public function name($value): void
    {
        $this->whereLike('name', $value);
    }

    public function code($value): void
    {
        $this->where('code', $value);
    }
}
