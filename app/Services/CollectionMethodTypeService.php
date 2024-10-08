<?php

namespace App\Services;

use App\Http\Requests\CollectionMethodType\DestroyRequest;
use App\Http\Requests\CollectionMethodType\IndexRequest;
use App\Http\Requests\CollectionMethodType\StoreRequest;
use App\Http\Requests\CollectionMethodType\UpdateRequest;
use App\Models\CollectionMethodType;
use App\Http\Resources\CollectionMethodTypeCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class CollectionMethodTypeService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = CollectionMethodType::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new CollectionMethodTypeCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, CollectionMethodType $collectionMethodType): CollectionMethodType
    {
        return DB::transaction(function() use ($request, $collectionMethodType) {
            $validated = $request->validated();
            $collectionMethodType->fill($validated);
            $collectionMethodType->save();
            return $collectionMethodType;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, CollectionMethodType $collectionMethodType): CollectionMethodType
    {
        return DB::transaction(function() use ($request, $collectionMethodType) {
            $validated = $request->validated();
            $collectionMethodType->fill($validated);
            $collectionMethodType->save();
            return $collectionMethodType;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, CollectionMethodType $collectionMethodType): CollectionMethodType
    {
        return DB::transaction(function() use ($request, $collectionMethodType) {
            $collectionMethodType->delete();
            return $collectionMethodType;
        });
    }
}
