<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\PaymentServiceProvider\DestroyRequest;
use App\Http\Requests\PaymentServiceProvider\IndexRequest;
use App\Http\Requests\PaymentServiceProvider\StoreRequest;
use App\Http\Requests\PaymentServiceProvider\UpdateRequest;
use App\Http\Resources\PaymentServiceProvider as PaymentServiceProviderResource;
use App\Models\PaymentServiceProvider;
use App\Services\PaymentServiceProviderService;
use Throwable;

class PaymentServiceProviderController extends Controller
{
    protected PaymentServiceProviderService $service;

    public function __construct(PaymentServiceProviderService $service)
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
    public function store(StoreRequest $request, PaymentServiceProvider $paymentServiceProvider)
    {
        //
        return ApiResponse::success(
            new PaymentServiceProviderResource($this->service->store($request, $paymentServiceProvider)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentServiceProvider $paymentServiceProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, PaymentServiceProvider $paymentServiceProvider)
    {
        //
        return ApiResponse::success(
            new PaymentServiceProviderResource($this->service->update($request, $paymentServiceProvider)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, PaymentServiceProvider $paymentServiceProvider)
    {
        //
        return ApiResponse::success(
            new PaymentServiceProviderResource($this->service->destroy($request, $paymentServiceProvider)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
