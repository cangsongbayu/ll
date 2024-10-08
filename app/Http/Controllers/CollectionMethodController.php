<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Http\Requests\CollectionMethod\DestroyRequest;
use App\Http\Requests\CollectionMethod\IndexRequest;
use App\Http\Requests\CollectionMethod\StoreRequest;
use App\Http\Requests\CollectionMethod\UpdateRequest;
use App\Http\Resources\CollectionMethod as CollectionMethodResource;
use App\Models\CollectionMethod;
use App\Services\CollectionMethodService;
use Throwable;

class CollectionMethodController extends Controller
{
    protected CollectionMethodService $service;

    public function __construct(CollectionMethodService $service)
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
    public function store(StoreRequest $request, CollectionMethod $collectionMethod)
    {
        //
        return ApiResponse::success(
            new CollectionMethodResource($this->service->store($request, $collectionMethod)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(CollectionMethod $collectionMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateRequest $request, CollectionMethod $collectionMethod)
    {
        //
        return ApiResponse::success(
            new CollectionMethodResource($this->service->update($request, $collectionMethod)),
            ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    /**
     * Remove the specified resource from storage.
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, CollectionMethod $collectionMethod)
    {
        //
        return ApiResponse::success(
            new CollectionMethodResource($this->service->destroy($request, $collectionMethod)),
            ApiMessageEnum::DESTROY->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
