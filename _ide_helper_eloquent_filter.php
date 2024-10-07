<?php

namespace Illuminate\Database\Eloquent {
    /**
     * @method static Builder filter($input = null, $filter = null)
     */
    class Builder {
        /**
         * Include soft deleted records in the results.
         *
         * @return Builder
         */
        public function withTrashed(): static
        {
            return $this;
        }

        /**
         * Get only soft deleted records.
         *
         * @return Builder
         */
        public function onlyTrashed(): static
        {
            return $this;
        }
    }
}

namespace EloquentFilter {

    use Illuminate\Database\Eloquent\Builder;

    /**
     * @mixin Builder
     */
    trait Filterable {}
}
