<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\Merchant\BatchDestroyRequest;
use App\Http\Requests\Merchant\BatchRestoreRequest;
use App\Http\Requests\Merchant\RestoreRequest;
use App\Http\Requests\Merchant\DestroyRequest;
use App\Http\Requests\Merchant\IndexRequest;
use App\Http\Requests\Merchant\StoreRequest;
use App\Http\Requests\Merchant\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Services\MerchantService;
use Throwable;

class MerchantController extends Controller
{
    protected MerchantService $service;

    public function __construct(MerchantService $service)
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

    public function all(Request $request)
    {
        return ApiResponse::success(
            $this->service->all($request),
            ApiMessageEnum::GENERAL_SUCCESS->getMessage(),
            ApiMessageShowTypeEnum::SILENT,
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(StoreRequest $request, Merchant $merchant)
    {
        //
        return ApiResponse::success(
            $this->service->store($request, $merchant),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Merchant $merchant)
    {
        //
        return ApiResponse::success(
            $this->service->update($request, $merchant),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Merchant $merchant)
    {
        //
        return ApiResponse::success(
            $this->service->destroy($request, $merchant),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * 恢复
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, Merchant $merchant)
    {
        //
        return ApiResponse::success(
            $this->service->restore($request, $merchant),
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
            ApiMessageEnum::BATCH_DESTROY->getMessageWithParams(['attribute' => __('attributes.merchant'), ...$data]),
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
            ApiMessageEnum::BATCH_RESTORE->getMessageWithParams(['attribute' => __('attributes.merchant'), ...$data]),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
