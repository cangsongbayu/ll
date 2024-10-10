<?php

namespace App\Services;

use App\Http\Requests\SupplierBill\DestroyRequest;
use App\Http\Requests\SupplierBill\IndexRequest;
use App\Http\Requests\SupplierBill\StoreRequest;
use App\Http\Requests\SupplierBill\UpdateRequest;
use App\Models\SupplierBill;
use App\Http\Resources\SupplierBillCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class SupplierBillService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = SupplierBill::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new SupplierBillCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, SupplierBill $supplierBill): SupplierBill
    {
        return DB::transaction(function() use ($request, $supplierBill) {
            $validated = $request->validated();
            $supplierBill->fill($validated);
            $supplierBill->save();
            return $supplierBill;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, SupplierBill $supplierBill): SupplierBill
    {
        return DB::transaction(function() use ($request, $supplierBill) {
            $validated = $request->validated();
            $supplierBill->fill($validated);
            $supplierBill->save();
            return $supplierBill;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, SupplierBill $supplierBill): SupplierBill
    {
        return DB::transaction(function() use ($request, $supplierBill) {
            $supplierBill->delete();
            return $supplierBill;
        });
    }
}
