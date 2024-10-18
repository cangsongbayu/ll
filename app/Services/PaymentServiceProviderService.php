<?php

namespace App\Services;

use App\Http\Requests\PaymentProvider\DestroyRequest;
use App\Http\Requests\PaymentProvider\IndexRequest;
use App\Http\Requests\PaymentProvider\StoreRequest;
use App\Http\Requests\PaymentProvider\UpdateRequest;
use App\Models\PaymentProvider;
use App\Http\Resources\PaymentProviderCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentServiceProviderService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = PaymentProvider::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new PaymentProviderCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, PaymentProvider $paymentProvider): PaymentProvider
    {
        return DB::transaction(function() use ($request, $paymentProvider) {
            $validated = $request->validated();
            $paymentProvider->fill($validated);
            $paymentProvider->save();
            return $paymentProvider;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, PaymentProvider $paymentProvider): PaymentProvider
    {
        return DB::transaction(function() use ($request, $paymentProvider) {
            $validated = $request->validated();
            $paymentProvider->fill($validated);
            $paymentProvider->save();
            return $paymentProvider;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, PaymentProvider $paymentProvider): PaymentProvider
    {
        return DB::transaction(function() use ($request, $paymentProvider) {
            $paymentProvider->delete();
            return $paymentProvider;
        });
    }
}
