<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\User\BatchDestroyRequest;
use App\Http\Requests\User\BatchRestoreRequest;
use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\RestoreRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Throwable;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
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
    public function store(StoreRequest $request, User $user)
    {
        //
        return ApiResponse::success(
            $this->service->store($request, $user),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, User $user)
    {
        //
        return ApiResponse::success(
            $this->service->update($request, $user),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, User $user)
    {
        //
        return ApiResponse::success(
            $this->service->destroy($request, $user),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * 恢复
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, User $user)
    {
        //
        return ApiResponse::success(
            $this->service->restore($request, $user),
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
            ApiMessageEnum::BATCH_DESTROY->getMessageWithParams(['attribute' => __('attributes.user'), ...$data]),
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
            ApiMessageEnum::BATCH_RESTORE->getMessageWithParams(['attribute' => __('attributes.user'), ...$data]),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
