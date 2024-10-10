<?php

namespace App\Services;

use App\Http\Requests\MerchantBill\DestroyRequest;
use App\Http\Requests\MerchantBill\IndexRequest;
use App\Http\Requests\MerchantBill\StoreRequest;
use App\Http\Requests\MerchantBill\UpdateRequest;
use App\Models\MerchantBill;
use App\Http\Resources\MerchantBillCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class MerchantBillService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = MerchantBill::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new MerchantBillCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, MerchantBill $merchantBill): MerchantBill
    {
        return DB::transaction(function() use ($request, $merchantBill) {
            $validated = $request->validated();
            $merchantBill->fill($validated);
            $merchantBill->save();
            return $merchantBill;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, MerchantBill $merchantBill): MerchantBill
    {
        return DB::transaction(function() use ($request, $merchantBill) {
            $validated = $request->validated();
            $merchantBill->fill($validated);
            $merchantBill->save();
            return $merchantBill;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, MerchantBill $merchantBill): MerchantBill
    {
        return DB::transaction(function() use ($request, $merchantBill) {
            $merchantBill->delete();
            return $merchantBill;
        });
    }
}
