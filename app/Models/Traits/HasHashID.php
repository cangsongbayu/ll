<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @mixin Model
 */

trait HasHashID
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        $value = current(Hashids::decode($value));

        if (empty($value)) {
            return null;
        }

        return parent::resolveRouteBinding($value);
    }
}
