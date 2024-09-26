<?php

namespace App\Services;

use App\Http\Requests\Currency\DestroyRequest;
use App\Http\Requests\Currency\IndexRequest;
use App\Http\Requests\Currency\StoreRequest;
use App\Http\Requests\Currency\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Http\Resources\CurrencyCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class CurrencyService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Currency::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new CurrencyCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    public function all(Request $request): array
    {
        $list = Currency::select(['id', 'code', 'symbol', 'name'])->filter($request->all())->get();
        return [
            'list' => new CurrencyCollection($list)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Currency $currency): Currency
    {
        return DB::transaction(function() use ($request, $currency) {
            $validated = $request->validated();
            $currency->fill($validated);
            $currency->save();
            return $currency;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Currency $currency): Currency
    {
        return DB::transaction(function() use ($request, $currency) {
            $validated = $request->validated();
            $currency->fill($validated);
            $currency->save();
            return $currency;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Currency $currency): Currency
    {
        return DB::transaction(function() use ($request, $currency) {
            $currency->delete();
            return $currency;
        });
    }
}
