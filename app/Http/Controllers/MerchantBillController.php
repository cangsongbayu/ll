<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\MerchantBill\DestroyRequest;
use App\Http\Requests\MerchantBill\IndexRequest;
use App\Http\Requests\MerchantBill\StoreRequest;
use App\Http\Requests\MerchantBill\UpdateRequest;
use App\Http\Resources\MerchantBill as MerchantBillResource;
use App\Models\MerchantBill;
use App\Services\MerchantBillService;
use Throwable;

class MerchantBillController extends Controller
{
    protected MerchantBillService $service;

    public function __construct(MerchantBillService $service)
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
    public function store(StoreRequest $request, MerchantBill $merchantBill)
    {
        //
        return ApiResponse::success(
            new MerchantBillResource($this->service->store($request, $merchantBill)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(MerchantBill $merchantBill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, MerchantBill $merchantBill)
    {
        //
        return ApiResponse::success(
            new MerchantBillResource($this->service->update($request, $merchantBill)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, MerchantBill $merchantBill)
    {
        //
        return ApiResponse::success(
            new MerchantBillResource($this->service->destroy($request, $merchantBill)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
