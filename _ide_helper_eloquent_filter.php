<?php

namespace Illuminate\Database\Eloquent {
    /**
     * @method static \Illuminate\Database\Eloquent\Builder filter($input = null, $filter = null)
     */
    class Builder {}
}

namespace EloquentFilter {

    use Illuminate\Database\Eloquent\Builder;

    /**
     * @mixin Builder
     */
    trait Filterable {}
}
