<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\Deposit\DestroyRequest;
use App\Http\Requests\Deposit\IndexRequest;
use App\Http\Requests\Deposit\StoreRequest;
use App\Http\Requests\Deposit\UpdateRequest;
use App\Models\Deposit;
use App\Services\DepositService;
use Throwable;

class DepositController extends Controller
{
    protected DepositService $service;

    public function __construct(DepositService $service)
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
    public function store(StoreRequest $request, Deposit $deposit)
    {
        //
        return ApiResponse::success(
            $this->service->store($request, $deposit),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Deposit $deposit)
    {
        //
        return ApiResponse::success(
            $this->service->update($request, $deposit),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Deposit $deposit)
    {
        //
        return ApiResponse::success(
            $this->service->destroy($request, $deposit),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
