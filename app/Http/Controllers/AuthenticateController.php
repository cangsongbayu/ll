<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Exceptions\LoginFailedException;
use App\Helpers\ApiResponse;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RepassRequest;
use App\Http\Requests\Authenticate\VerifyTFARequest;
use App\Services\AuthenticateService;
use Illuminate\Http\Request;
use Throwable;

class AuthenticateController extends Controller
{
    protected AuthenticateService $service;

    public function __construct(AuthenticateService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws LoginFailedException
     * @throws Throwable
     */
    public function login(LoginRequest $request)
    {
        return ApiResponse::success(
            $this->service->login($request),
            ApiMessageEnum::LOGIN->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }

    public function me(Request $request)
    {
        return ApiResponse::success(
            $this->service->me($request),
            ApiMessageEnum::GENERAL_SUCCESS->getMessage(),
            ApiMessageShowTypeEnum::SILENT,
        );
    }

    /**
     * @throws Throwable
     */
    public function repass(RepassRequest $request)
    {
        return ApiResponse::success(
            $this->service->repass($request),
            ApiMessageEnum::REPASS->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS
        );
    }

    /**
     * @throws Throwable
     */
    public function logout(Request $request)
    {
        return ApiResponse::success(
            $this->service->logout($request),
            ApiMessageEnum::LOGOUT->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS
        );
    }

    /**
     * @throws Throwable
     */
    public function getTFAQRCode(Request $request)
    {
        return ApiResponse::success(
            $this->service->getTFAQRCode($request),
            ApiMessageEnum::GENERAL_SUCCESS->getMessage(),
            ApiMessageShowTypeEnum::SILENT
        );
    }

    /**
     * @throws Throwable
     */
    public function verifyTFA(VerifyTFARequest $request)
    {
        $user = $this->service->verifyTFA($request);
        $message = $user->is_enable_tfa ? ApiMessageEnum::ENABLE_TFA : ApiMessageEnum::DISABLE_TFA;
        $showType = $user->is_enable_tfa ? ApiMessageShowTypeEnum::SUCCESS : ApiMessageShowTypeEnum::WARNING;
        return ApiResponse::success(
            $user,
            $message->getMessage(),
            $showType,
        );
    }
}
