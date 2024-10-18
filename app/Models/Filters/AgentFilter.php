<?php

namespace App\Models\Filters;

use App\Models\Agent;

class AgentFilter extends BaseModelFilter
{
    public function trashed($value): void
    {
        if ($value === 'only') {
            /** @var Agent $this */
            $this->onlyTrashed();
        }
    }
}
