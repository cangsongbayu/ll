<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\SupplierBill\DestroyRequest;
use App\Http\Requests\SupplierBill\IndexRequest;
use App\Http\Requests\SupplierBill\StoreRequest;
use App\Http\Requests\SupplierBill\UpdateRequest;
use App\Http\Resources\SupplierBill as SupplierBillResource;
use App\Models\SupplierBill;
use App\Services\SupplierBillService;
use Throwable;

class SupplierBillController extends Controller
{
    protected SupplierBillService $service;

    public function __construct(SupplierBillService $service)
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
    public function store(StoreRequest $request, SupplierBill $supplierBill)
    {
        //
        return ApiResponse::success(
            new SupplierBillResource($this->service->store($request, $supplierBill)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplierBill $supplierBill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, SupplierBill $supplierBill)
    {
        //
        return ApiResponse::success(
            new SupplierBillResource($this->service->update($request, $supplierBill)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, SupplierBill $supplierBill)
    {
        //
        return ApiResponse::success(
            new SupplierBillResource($this->service->destroy($request, $supplierBill)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
