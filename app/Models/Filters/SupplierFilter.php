<?php

namespace App\Models\Filters;

use App\Models\Supplier;

class SupplierFilter extends BaseModelFilter
{
    public function trashed($value): void
    {
        if ($value === 'only') {
            /** @var Supplier $this */
            $this->onlyTrashed();
        }
    }
}
