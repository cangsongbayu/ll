<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\MerchantPrepayment\DestroyRequest;
use App\Http\Requests\MerchantPrepayment\IndexRequest;
use App\Http\Requests\MerchantPrepayment\StoreRequest;
use App\Http\Requests\MerchantPrepayment\UpdateRequest;
use App\Models\MerchantPrepayment;
use App\Services\MerchantPrepaymentService;
use Throwable;

class MerchantPrepaymentController extends Controller
{
    protected MerchantPrepaymentService $service;

    public function __construct(MerchantPrepaymentService $service)
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
    public function store(StoreRequest $request, MerchantPrepayment $merchantPrepayment)
    {
        //
        return ApiResponse::success(
            $this->service->store($request, $merchantPrepayment),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(MerchantPrepayment $merchantPrepayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, MerchantPrepayment $merchantPrepayment)
    {
        //
        return ApiResponse::success(
            $this->service->update($request, $merchantPrepayment),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, MerchantPrepayment $merchantPrepayment)
    {
        //
        return ApiResponse::success(
            $this->service->destroy($request, $merchantPrepayment),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
