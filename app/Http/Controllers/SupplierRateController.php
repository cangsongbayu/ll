<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\SupplierRate\DestroyRequest;
use App\Http\Requests\SupplierRate\IndexRequest;
use App\Http\Requests\SupplierRate\StoreRequest;
use App\Http\Requests\SupplierRate\UpdateRequest;
use App\Http\Requests\SupplierRate\RestoreRequest;
use App\Http\Requests\SupplierRate\BatchRestoreRequest;
use App\Http\Requests\SupplierRate\BatchDestroyRequest;
use App\Http\Resources\SupplierRate as SupplierRateResource;
use App\Models\SupplierRate;
use App\Services\SupplierRateService;
use Throwable;

class SupplierRateController extends Controller
{
    protected SupplierRateService $service;

    public function __construct(SupplierRateService $service)
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
    public function store(StoreRequest $request, SupplierRate $supplierRate)
    {
        //
        return ApiResponse::success(
            new SupplierRateResource($this->service->store($request, $supplierRate)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplierRate $supplierRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, SupplierRate $supplierRate)
    {
        //
        return ApiResponse::success(
            new SupplierRateResource($this->service->update($request, $supplierRate)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, SupplierRate $supplierRate)
    {
        //
        return ApiResponse::success(
            new SupplierRateResource($this->service->destroy($request, $supplierRate)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * 恢复
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, SupplierRate $supplierRate)
    {
        //
        return ApiResponse::success(
            new SupplierRateResource($this->service->restore($request, $supplierRate)),
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
            ApiMessageEnum::BATCH_DESTROY->getMessageWithParams(['attribute' => __('attributes.rate'), ...$data]),
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
            ApiMessageEnum::BATCH_RESTORE->getMessageWithParams(['attribute' => __('attributes.rate'), ...$data]),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
