<?php

namespace App\Services;

abstract class Service
{
    public function getApiPaginate($lengthAwarePaginator): array
    {
        return [
            'total' => $lengthAwarePaginator->total(),
            'count' => $lengthAwarePaginator->count(),
            'current_page' => $lengthAwarePaginator->currentPage(),
            'total_page' => $lengthAwarePaginator->lastPage(),
            'per_page' => $lengthAwarePaginator->perPage(),
        ];
    }
}
