<?php

namespace App\Services;

use App\Enums\CollectionMethodFieldTypeEnum;
use App\Http\Requests\CollectionMethod\DestroyRequest;
use App\Http\Requests\CollectionMethod\IndexRequest;
use App\Http\Requests\CollectionMethod\StoreRequest;
use App\Http\Requests\CollectionMethod\UpdateRequest;
use App\Models\CollectionMethod;
use App\Http\Resources\CollectionMethodCollection;
use App\Models\TemporaryUploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
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
            // 获取收款方式类型
            $collectionMethodType = $request->getCollectionMethodType();
            // 获取需要处理的动态字段
            $fields = Arr::get($collectionMethodType->data, 'fields', []);
            $data = [];
            foreach ($fields as $field) {
                $type = Arr::get($field, 'type');
                if ($type === CollectionMethodFieldTypeEnum::STRING->value) {
                    $data[$field['name']] = $request->input($field['name']);
                } else if ($type === CollectionMethodFieldTypeEnum::QR_FILE->value) {
                    // 根据回传的 context 信息获取文件信息
                    $data = array_merge($data, $request->input('context'));
                    // 删除临时文件
                    TemporaryUploadFile::where('path', $data['path'])->delete();
                }
            }
            $collectionMethod->fill(array_merge($validated, ['data' => $data]));
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
