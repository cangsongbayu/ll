<?php

namespace App\Services;

use App\Http\Requests\Merchant\DestroyRequest;
use App\Http\Requests\Merchant\IndexRequest;
use App\Http\Requests\Merchant\StoreRequest;
use App\Http\Requests\Merchant\UpdateRequest;
use App\Http\Requests\Merchant\BatchDestroyRequest;
use App\Http\Requests\Merchant\BatchRestoreRequest;
use App\Http\Requests\Merchant\RestoreRequest;
use App\Models\Merchant;
use App\Http\Resources\MerchantCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class MerchantService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Merchant::query()->filter($request->input(config('app.filters'), []));
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new MerchantCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Merchant $merchant): Merchant
    {
        return DB::transaction(function() use ($request, $merchant) {
            $validated = $request->validated();
            $merchant->fill($validated);
            $merchant->save();
            return $merchant;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Merchant $merchant): Merchant
    {
        return DB::transaction(function() use ($request, $merchant) {
            $validated = $request->validated();
            $merchant->fill($validated);
            $merchant->save();
            return $merchant;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Merchant $merchant): Merchant
    {
        return DB::transaction(function() use ($request, $merchant) {
            Merchant::deleteTokens($merchant->id); // 删除用户的所有 token
            $merchant->delete();
            return $merchant;
        });
    }

    /**
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, Merchant $merchant): Merchant
    {
        return DB::transaction(function() use ($request, $merchant) {
            $merchant->restore();
            return $merchant;
        });
    }

    /**
     * @throws Throwable
     */
    public function batchDestroy(BatchDestroyRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            Merchant::deleteTokens($ids); // 删除用户的所有 token
            return Merchant::whereIn('id', $ids)->delete();
        });
    }

    /**
     * @throws Throwable
     */
    public function batchRestore(BatchRestoreRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            return Merchant::withTrashed()->whereIn('id', $ids)->restore();
        });
    }
}
