<?php

namespace App\Models\Filters;

use App\Models\MerchantRate;

class MerchantRateFilter extends BaseModelFilter
{
    public function trashed($value): void
    {
        if ($value === 'only') {
            /** @var MerchantRate $this */
            $this->onlyTrashed();
        }
    }
}
