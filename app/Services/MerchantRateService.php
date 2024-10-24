<?php

namespace App\Services;

use App\Http\Requests\FormRequest;
use App\Http\Requests\MerchantRate\DestroyRequest;
use App\Http\Requests\MerchantRate\IndexRequest;
use App\Http\Requests\MerchantRate\StoreRequest;
use App\Http\Requests\MerchantRate\UpdateRequest;
use App\Http\Requests\MerchantRate\RestoreRequest;
use App\Http\Requests\MerchantRate\BatchDestroyRequest;
use App\Http\Requests\MerchantRate\BatchRestoreRequest;
use App\Http\Requests\MerchantRate\AllRequest;
use Illuminate\Http\Request;
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

    public function all(Request $request): array
    {

        $list = MerchantRate::select(['id', 'payment_type_id',  'rate', 'platform_rate', 'rebate', 'is_open_for_business','valid_amount','deleted_at'])
            ->where('merchant_id',$request->merchant_id)
            ->withTrashed()
            ->get();

        return [
            'list' => new MerchantRateCollection($list)
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

    /**
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, MerchantRate $merchantRate): MerchantRate
    {
        return DB::transaction(function() use ($request, $merchantRate) {
            $merchantRate->restore();
            return $merchantRate;
        });
    }

    /**
     * @throws Throwable
     */
    public function batchDestroy(BatchDestroyRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            return MerchantRate::whereIn('id', $ids)->delete();
        });
    }

    /**
     * @throws Throwable
     */
    public function batchRestore(BatchRestoreRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            return MerchantRate::onlyTrashed()->whereIn('id', $ids)->restore();
        });
    }
}
