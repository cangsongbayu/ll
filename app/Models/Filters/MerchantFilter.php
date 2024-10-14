<?php

namespace App\Models\Filters;

use App\Models\Merchant;

class MerchantFilter extends BaseModelFilter
{
    public function trashed($value): void
    {
        if ($value === 'only') {
            /** @var Merchant $this */
            $this->onlyTrashed();
        }
    }
}
