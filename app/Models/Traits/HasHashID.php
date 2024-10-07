<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Vinkla\Hashids\Facades\Hashids;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @mixin Model
 */

trait HasHashID
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @param string|null $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->resolveRouteBindingQuery($this, $this->getId($value), $field)->first();
    }

    public function resolveSoftDeletableRouteBinding($value, $field = null): Model|Relation|Builder|null
    {
        return $this->resolveRouteBindingQuery($this, $this->getId($value), $field)->withTrashed()->first();
    }

    public function getId($value)
    {
        $value = current(Hashids::decode($value));

        if (empty($value)) {
            throw new NotFoundHttpException();
        }

        return $value;
    }
}
