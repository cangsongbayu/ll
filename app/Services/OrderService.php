<?php

namespace App\Services;

use App\Http\Requests\Order\DestroyRequest;
use App\Http\Requests\Order\IndexRequest;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\Http\Resources\OrderCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Order::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new OrderCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Order $order): Order
    {
        return DB::transaction(function() use ($request, $order) {
            $validated = $request->validated();
            $order->fill($validated);
            $order->save();
            return $order;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Order $order): Order
    {
        return DB::transaction(function() use ($request, $order) {
            $validated = $request->validated();
            $order->fill($validated);
            $order->save();
            return $order;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Order $order): Order
    {
        return DB::transaction(function() use ($request, $order) {
            $order->delete();
            return $order;
        });
    }
}
