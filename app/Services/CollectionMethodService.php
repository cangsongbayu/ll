<?php

namespace App\Services;

use App\Http\Requests\CollectionMethod\DestroyRequest;
use App\Http\Requests\CollectionMethod\IndexRequest;
use App\Http\Requests\CollectionMethod\StoreRequest;
use App\Http\Requests\CollectionMethod\UpdateRequest;
use App\Models\CollectionMethod;
use App\Http\Resources\CollectionMethodCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class CollectionMethodService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = CollectionMethod::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new CollectionMethodCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, CollectionMethod $collectionMethod): CollectionMethod
    {
        return DB::transaction(function() use ($request, $collectionMethod) {
            $validated = $request->validated();
            $collectionMethod->fill($validated);
            $collectionMethod->save();
            return $collectionMethod;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, CollectionMethod $collectionMethod): CollectionMethod
    {
        return DB::transaction(function() use ($request, $collectionMethod) {
            $validated = $request->validated();
            $collectionMethod->fill($validated);
            $collectionMethod->save();
            return $collectionMethod;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, CollectionMethod $collectionMethod): CollectionMethod
    {
        return DB::transaction(function() use ($request, $collectionMethod) {
            $collectionMethod->delete();
            return $collectionMethod;
        });
    }
}