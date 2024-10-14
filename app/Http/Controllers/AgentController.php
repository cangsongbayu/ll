<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\Agent\DestroyRequest;
use App\Http\Requests\Agent\IndexRequest;
use App\Http\Requests\Agent\StoreRequest;
use App\Http\Requests\Agent\UpdateRequest;
use App\Http\Requests\Agent\RestoreRequest;
use App\Http\Requests\Agent\BatchDestroyRequest;
use App\Http\Requests\Agent\BatchRestoreRequest;
use App\Http\Resources\Agent as AgentResource;
use App\Models\Agent;
use App\Services\AgentService;
use Illuminate\Http\Request;
use Throwable;

class AgentController extends Controller
{
    protected AgentService $service;

    public function __construct(AgentService $service)
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
    public function store(StoreRequest $request, Agent $agent)
    {
        //
        return ApiResponse::success(
            new AgentResource($this->service->store($request, $agent)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Agent $agent)
    {
        //
        return ApiResponse::success(
            new AgentResource($this->service->update($request, $agent)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Agent $agent)
    {
        //
        return ApiResponse::success(
            new AgentResource($this->service->destroy($request, $agent)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * 恢复
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, Agent $agent)
    {
        //
        return ApiResponse::success(
            new AgentResource($this->service->restore($request, $agent)),
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
            ApiMessageEnum::BATCH_DESTROY->getMessageWithParams(['attribute' => __('attributes.agent'), ...$data]),
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
            ApiMessageEnum::BATCH_RESTORE->getMessageWithParams(['attribute' => __('attributes.agent'), ...$data]),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
