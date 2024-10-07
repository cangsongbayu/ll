<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\Supplier\DestroyRequest;
use App\Http\Requests\Supplier\IndexRequest;
use App\Http\Requests\Supplier\StoreRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Http\Requests\Supplier\RestoreRequest;
use App\Http\Requests\Supplier\BatchDestroyRequest;
use App\Http\Requests\Supplier\BatchRestoreRequest;
use App\Http\Resources\Supplier as SupplierResource;
use App\Models\Supplier;
use App\Services\SupplierService;
use Throwable;

class SupplierController extends Controller
{
    protected SupplierService $service;

    public function __construct(SupplierService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        //
        return ApiResponse::success(
            $this->service->index($request),
            ApiMessageEnum::INDEX->getMessage(),
            ApiMessageShowTypeEnum::SILENT,
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(StoreRequest $request, Supplier $supplier)
    {
        //
        return ApiResponse::success(
            new SupplierResource($this->service->store($request, $supplier)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Supplier $supplier)
    {
        //
        return ApiResponse::success(
            new SupplierResource($this->service->update($request, $supplier)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Supplier $supplier)
    {
        //
        return ApiResponse::success(
            new SupplierResource($this->service->destroy($request, $supplier)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * 恢复
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, Supplier $supplier)
    {
        //
        return ApiResponse::success(
            new SupplierResource($this->service->restore($request, $supplier)),
            ApiMessageEnum::RESTORE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * 批量删除
     * @throws Throwable
     */
    public function batchDestroy(BatchDestroyRequest $request)
    {
        $count = $this->service->batchDestroy($request);
        $data = ['count' => $count];
        return ApiResponse::success(
            $data,
            ApiMessageEnum::BATCH_DESTROY->getMessageWithParams(['attribute' => __('attributes.supplier'), ...$data]),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
    /**
     * 批量恢复
     * @throws Throwable
     */
    public function batchRestore(BatchRestoreRequest $request)
    {
        $count = $this->service->batchRestore($request);
        $data = ['count' => $count];
        return ApiResponse::success(
            $data,
            ApiMessageEnum::BATCH_RESTORE->getMessageWithParams(['attribute' => __('attributes.supplier'), ...$data]),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
