<?php

namespace App\Services;

use App\Http\Requests\Supplier\BatchRestoreRequest;
use App\Http\Requests\Supplier\BatchDestroyRequest;
use App\Http\Requests\Supplier\RestoreRequest;
use App\Http\Requests\Supplier\DestroyRequest;
use App\Http\Requests\Supplier\IndexRequest;
use App\Http\Requests\Supplier\StoreRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Models\Supplier;
use App\Http\Resources\SupplierCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class SupplierService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Supplier::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new SupplierCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Supplier $supplier): Supplier
    {
        return DB::transaction(function() use ($request, $supplier) {
            $validated = $request->validated();
            $supplier->fill($validated);
            $supplier->save();
            return $supplier;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Supplier $supplier): Supplier
    {
        return DB::transaction(function() use ($request, $supplier) {
            $validated = $request->validated();
            $supplier->fill($validated);
            $supplier->save();
            return $supplier;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Supplier $supplier): Supplier
    {
        return DB::transaction(function() use ($request, $supplier) {
            $supplier->delete();
            return $supplier;
        });
    }

    /**
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, Supplier $supplier): Supplier
    {
        return DB::transaction(function() use ($request, $supplier) {
            $supplier->restore();
            return $supplier;
        });
    }

    /**
     * @throws Throwable
     */
    public function batchDestroy(BatchDestroyRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            Supplier::deleteTokens($ids); // 删除用户的所有 token
//            Supplier::deleteRates($ids); // 删除用户的所有费率
            return Supplier::whereIn('id', $ids)->delete();
        });
    }

    /**
     * @throws Throwable
     */
    public function batchRestore(BatchRestoreRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
//            Supplier::restoreRates($ids); // 恢复用户的所有费率
            return Supplier::withTrashed()->whereIn('id', $ids)->restore();
        });
    }
}
