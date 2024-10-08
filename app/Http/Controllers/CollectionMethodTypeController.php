<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\CollectionMethodType\DestroyRequest;
use App\Http\Requests\CollectionMethodType\IndexRequest;
use App\Http\Requests\CollectionMethodType\StoreRequest;
use App\Http\Requests\CollectionMethodType\UpdateRequest;
use App\Http\Resources\CollectionMethodType as CollectionMethodTypeResource;
use App\Models\CollectionMethodType;
use App\Services\CollectionMethodTypeService;
use Throwable;

class CollectionMethodTypeController extends Controller
{
    protected CollectionMethodTypeService $service;

    public function __construct(CollectionMethodTypeService $service)
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
    public function store(StoreRequest $request, CollectionMethodType $collectionMethodType)
    {
        //
        return ApiResponse::success(
            new CollectionMethodTypeResource($this->service->store($request, $collectionMethodType)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(CollectionMethodType $collectionMethodType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, CollectionMethodType $collectionMethodType)
    {
        //
        return ApiResponse::success(
            new CollectionMethodTypeResource($this->service->update($request, $collectionMethodType)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, CollectionMethodType $collectionMethodType)
    {
        //
        return ApiResponse::success(
            new CollectionMethodTypeResource($this->service->destroy($request, $collectionMethodType)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
