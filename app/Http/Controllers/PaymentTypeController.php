<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\PaymentType\DestroyRequest;
use App\Http\Requests\PaymentType\IndexRequest;
use App\Http\Requests\PaymentType\StoreRequest;
use App\Http\Requests\PaymentType\UpdateRequest;
use App\Http\Resources\PaymentType as PaymentTypeResource;
use App\Models\PaymentType;
use App\Services\PaymentTypeService;
use Illuminate\Http\Request;
use Throwable;

class PaymentTypeController extends Controller
{
    protected PaymentTypeService $service;

    public function __construct(PaymentTypeService $service)
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
    public function store(StoreRequest $request, PaymentType $paymentType)
    {
        //
        return ApiResponse::success(
            new PaymentTypeResource($this->service->store($request, $paymentType)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentType $paymentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, PaymentType $paymentType)
    {
        //
        return ApiResponse::success(
            new PaymentTypeResource($this->service->update($request, $paymentType)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, PaymentType $paymentType)
    {
        //
        return ApiResponse::success(
            new PaymentTypeResource($this->service->destroy($request, $paymentType)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
