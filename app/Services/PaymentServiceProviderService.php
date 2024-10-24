<?php

namespace App\Services;

use App\Http\Requests\PaymentServiceProvider\DestroyRequest;
use App\Http\Requests\PaymentServiceProvider\IndexRequest;
use App\Http\Requests\PaymentServiceProvider\StoreRequest;
use App\Http\Requests\PaymentServiceProvider\UpdateRequest;
use App\Models\PaymentServiceProvider;
use App\Http\Resources\PaymentServiceProviderCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentServiceProviderService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = PaymentServiceProvider::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new PaymentServiceProviderCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, PaymentServiceProvider $paymentServiceProvider): PaymentServiceProvider
    {
        return DB::transaction(function() use ($request, $paymentServiceProvider) {
            $validated = $request->validated();
            $paymentServiceProvider->fill($validated);
            $paymentServiceProvider->save();
            return $paymentServiceProvider;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, PaymentServiceProvider $paymentServiceProvider): PaymentServiceProvider
    {
        return DB::transaction(function() use ($request, $paymentServiceProvider) {
            $validated = $request->validated();
            $paymentServiceProvider->fill($validated);
            $paymentServiceProvider->save();
            return $paymentServiceProvider;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, PaymentServiceProvider $paymentServiceProvider): PaymentServiceProvider
    {
        return DB::transaction(function() use ($request, $paymentServiceProvider) {
            $paymentServiceProvider->delete();
            return $paymentServiceProvider;
        });
    }
}
