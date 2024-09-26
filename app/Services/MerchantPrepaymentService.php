<?php

namespace App\Services;

use App\Http\Requests\MerchantPrepayment\DestroyRequest;
use App\Http\Requests\MerchantPrepayment\IndexRequest;
use App\Http\Requests\MerchantPrepayment\StoreRequest;
use App\Http\Requests\MerchantPrepayment\UpdateRequest;
use App\Models\MerchantPrepayment;
use App\Http\Resources\MerchantPrepaymentCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class MerchantPrepaymentService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = MerchantPrepayment::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new MerchantPrepaymentCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, MerchantPrepayment $merchantPrepayment): MerchantPrepayment
    {
        return DB::transaction(function() use ($request, $merchantPrepayment) {
            $validated = $request->validated();
            $merchantPrepayment->fill($validated);
            $merchantPrepayment->save();
            return $merchantPrepayment;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, MerchantPrepayment $merchantPrepayment): MerchantPrepayment
    {
        return DB::transaction(function() use ($request, $merchantPrepayment) {
            $validated = $request->validated();
            $merchantPrepayment->fill($validated);
            $merchantPrepayment->save();
            return $merchantPrepayment;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, MerchantPrepayment $merchantPrepayment): MerchantPrepayment
    {
        return DB::transaction(function() use ($request, $merchantPrepayment) {
            $merchantPrepayment->delete();
            return $merchantPrepayment;
        });
    }
}
