<?php

namespace App\Services;

use App\Http\Requests\SupplierRate\DestroyRequest;
use App\Http\Requests\SupplierRate\IndexRequest;
use App\Http\Requests\SupplierRate\StoreRequest;
use App\Http\Requests\SupplierRate\UpdateRequest;
use App\Http\Requests\SupplierRate\RestoreRequest;
use App\Http\Requests\SupplierRate\BatchRestoreRequest;
use App\Http\Requests\SupplierRate\BatchDestroyRequest;
use App\Models\SupplierRate;
use App\Http\Resources\SupplierRateCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class SupplierRateService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = SupplierRate::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new SupplierRateCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, SupplierRate $supplierRate): SupplierRate
    {
        return DB::transaction(function() use ($request, $supplierRate) {
            $validated = $request->validated();
            $supplierRate->fill($validated);
            $supplierRate->save();
            return $supplierRate;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, SupplierRate $supplierRate): SupplierRate
    {
        return DB::transaction(function() use ($request, $supplierRate) {
            $validated = $request->validated();
            $supplierRate->fill($validated);
            $supplierRate->save();
            return $supplierRate;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, SupplierRate $supplierRate): SupplierRate
    {
        return DB::transaction(function() use ($request, $supplierRate) {
            $supplierRate->delete();
            return $supplierRate;
        });
    }

    /**
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, SupplierRate $supplierRate): SupplierRate
    {
        return DB::transaction(function() use ($request, $supplierRate) {
            $supplierRate->restore();
            return $supplierRate;
        });
    }

    /**
     * @throws Throwable
     */
    public function batchDestroy(BatchDestroyRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            return SupplierRate::whereIn('id', $ids)->delete();
        });
    }

    /**
     * @throws Throwable
     */
    public function batchRestore(BatchRestoreRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            return SupplierRate::onlyTrashed()->whereIn('id', $ids)->restore();
        });
    }
}
