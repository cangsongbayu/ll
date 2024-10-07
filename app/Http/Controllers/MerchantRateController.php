<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\MerchantRate\DestroyRequest;
use App\Http\Requests\MerchantRate\IndexRequest;
use App\Http\Requests\MerchantRate\StoreRequest;
use App\Http\Requests\MerchantRate\UpdateRequest;
use App\Http\Requests\MerchantRate\RestoreRequest;
use App\Http\Requests\MerchantRate\BatchDestroyRequest;
use App\Http\Requests\MerchantRate\BatchRestoreRequest;
use App\Http\Resources\MerchantRate as MerchantRateResource;
use App\Models\MerchantRate;
use App\Services\MerchantRateService;
use Throwable;

class MerchantRateController extends Controller
{
    protected MerchantRateService $service;

    public function __construct(MerchantRateService $service)
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
    public function store(StoreRequest $request, MerchantRate $merchantRate)
    {
        //
        return ApiResponse::success(
            new MerchantRateResource($this->service->store($request, $merchantRate)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(MerchantRate $merchantRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, MerchantRate $merchantRate)
    {
        //
        return ApiResponse::success(
            new MerchantRateResource($this->service->update($request, $merchantRate)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, MerchantRate $merchantRate)
    {
        //
        return ApiResponse::success(
            new MerchantRateResource($this->service->destroy($request, $merchantRate)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * 恢复
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, MerchantRate $merchantRate)
    {
        //
        return ApiResponse::success(
            new MerchantRateResource($this->service->restore($request, $merchantRate)),
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
