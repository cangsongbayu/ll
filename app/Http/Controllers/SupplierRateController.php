<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\SupplierRate\DestroyRequest;
use App\Http\Requests\SupplierRate\IndexRequest;
use App\Http\Requests\SupplierRate\StoreRequest;
use App\Http\Requests\SupplierRate\UpdateRequest;
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
}
