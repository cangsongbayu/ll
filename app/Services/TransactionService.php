<?php

namespace App\Services;

use App\Http\Requests\Transaction\DestroyRequest;
use App\Http\Requests\Transaction\IndexRequest;
use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Models\Transaction;
use App\Http\Resources\TransactionCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransactionService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Transaction::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new TransactionCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Transaction $transaction): Transaction
    {
        return DB::transaction(function() use ($request, $transaction) {
            $validated = $request->validated();
            $transaction->fill($validated);
            $transaction->save();
            return $transaction;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Transaction $transaction): Transaction
    {
        return DB::transaction(function() use ($request, $transaction) {
            $validated = $request->validated();
            $transaction->fill($validated);
            $transaction->save();
            return $transaction;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Transaction $transaction): Transaction
    {
        return DB::transaction(function() use ($request, $transaction) {
            $transaction->delete();
            return $transaction;
        });
    }
}
