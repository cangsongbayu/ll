<?php

namespace App\Services;

use App\Http\Requests\MerchantRate\DestroyRequest;
use App\Http\Requests\MerchantRate\IndexRequest;
use App\Http\Requests\MerchantRate\StoreRequest;
use App\Http\Requests\MerchantRate\UpdateRequest;
use App\Models\MerchantRate;
use App\Http\Resources\MerchantRateCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class MerchantRateService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = MerchantRate::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new MerchantRateCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, MerchantRate $merchantRate): MerchantRate
    {
        return DB::transaction(function() use ($request, $merchantRate) {
            $validated = $request->validated();
            $merchantRate->fill($validated);
            $merchantRate->save();
            return $merchantRate;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, MerchantRate $merchantRate): MerchantRate
    {
        return DB::transaction(function() use ($request, $merchantRate) {
            $validated = $request->validated();
            $merchantRate->fill($validated);
            $merchantRate->save();
            return $merchantRate;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, MerchantRate $merchantRate): MerchantRate
    {
        return DB::transaction(function() use ($request, $merchantRate) {
            $merchantRate->delete();
            return $merchantRate;
        });
    }
}
