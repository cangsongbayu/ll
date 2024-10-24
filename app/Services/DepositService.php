<?php

namespace App\Services;

use App\Http\Requests\Deposit\DestroyRequest;
use App\Http\Requests\Deposit\IndexRequest;
use App\Http\Requests\Deposit\StoreRequest;
use App\Http\Requests\Deposit\UpdateRequest;
use App\Models\Deposit;
use App\Http\Resources\DepositCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class DepositService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Deposit::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new DepositCollection($lengthAwarePaginator);
        // 计算统计数据
        $statistics = [
            'total_base_amount' => $query->sum('base_amount'),
        ];
        return [
            'list' => $list,
            'statistics' => $statistics,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Deposit $deposit): Deposit
    {
        return DB::transaction(function() use ($request, $deposit) {
            $validated = $request->validated();
            $deposit->fill($validated);
            $deposit->save();
            return $deposit;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Deposit $deposit): Deposit
    {
        return DB::transaction(function() use ($request, $deposit) {
            $validated = $request->validated();
            $deposit->fill($validated);
            $deposit->save();
            return $deposit;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Deposit $deposit): Deposit
    {
        return DB::transaction(function() use ($request, $deposit) {
            $deposit->delete();
            return $deposit;
        });
    }
}
