<?php

namespace App\Services;

use App\Http\Requests\Tenant\DestroyRequest;
use App\Http\Requests\Tenant\IndexRequest;
use App\Http\Requests\Tenant\StoreRequest;
use App\Http\Requests\Tenant\UpdateRequest;
use App\Models\Tenant;
use App\Http\Resources\TenantCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class TenantService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Tenant::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new TenantCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Tenant $tenant): Tenant
    {
        return DB::transaction(function() use ($request, $tenant) {
            $validated = $request->validated();
            $tenant->fill($validated);
            $tenant->save();
            return $tenant;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Tenant $tenant): Tenant
    {
        return DB::transaction(function() use ($request, $tenant) {
            $validated = $request->validated();
            $tenant->fill($validated);
            $tenant->save();
            return $tenant;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Tenant $tenant): Tenant
    {
        return DB::transaction(function() use ($request, $tenant) {
            $tenant->delete();
            return $tenant;
        });
    }
}
