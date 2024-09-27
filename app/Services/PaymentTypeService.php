<?php

namespace App\Services;

use App\Http\Requests\PaymentType\DestroyRequest;
use App\Http\Requests\PaymentType\IndexRequest;
use App\Http\Requests\PaymentType\StoreRequest;
use App\Http\Requests\PaymentType\UpdateRequest;
use App\Models\PaymentType;
use App\Http\Resources\PaymentTypeCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentTypeService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = PaymentType::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new PaymentTypeCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    public function all(Request $request): array
    {
        $list = PaymentType::select(['id', 'name'])->filter($request->all())->get();
        return [
            'list' => new PaymentTypeCollection($list)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, PaymentType $paymentType): PaymentType
    {
        return DB::transaction(function() use ($request, $paymentType) {
            $validated = $request->validated();
            $paymentType->fill($validated);
            $paymentType->save();
            return $paymentType;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, PaymentType $paymentType): PaymentType
    {
        return DB::transaction(function() use ($request, $paymentType) {
            $validated = $request->validated();
            $paymentType->fill($validated);
            $paymentType->save();
            return $paymentType;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, PaymentType $paymentType): PaymentType
    {
        return DB::transaction(function() use ($request, $paymentType) {
            $paymentType->delete();
            return $paymentType;
        });
    }
}
