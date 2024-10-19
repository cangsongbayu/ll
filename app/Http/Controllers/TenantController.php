<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\Tenant\DestroyRequest;
use App\Http\Requests\Tenant\IndexRequest;
use App\Http\Requests\Tenant\StoreRequest;
use App\Http\Requests\Tenant\UpdateRequest;
use App\Http\Resources\Tenant as TenantResource;
use App\Models\Tenant;
use App\Services\TenantService;
use Throwable;

class TenantController extends Controller
{
    protected TenantService $service;

    public function __construct(TenantService $service)
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
    public function store(StoreRequest $request, Tenant $tenant)
    {
        //
        return ApiResponse::success(
            new TenantResource($this->service->store($request, $tenant)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Tenant $tenant)
    {
        //
        return ApiResponse::success(
            new TenantResource($this->service->update($request, $tenant)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Tenant $tenant)
    {
        //
        return ApiResponse::success(
            new TenantResource($this->service->destroy($request, $tenant)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    public function validation($id)
    {
        $exists = Tenant::where('id', $id)->exists();
        return ApiResponse::success(
            ['exists' => $exists],
            ApiMessageEnum::GENERAL_SUCCESS->getMessage(),
            ApiMessageShowTypeEnum::SILENT,
        );
    }
}
