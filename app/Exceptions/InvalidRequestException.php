<?php

namespace App\Exceptions;

use App\Enums\ApiErrorCodeEnum;
use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class InvalidRequestException extends Exception
{
    //
    public function render(): JsonResponse
    {
        $message = $this->getMessage();
        return ApiResponse::fail(
            $message ?: ApiErrorCodeEnum::INVALID_REQUEST->getErrorMessage(),
            ApiErrorCodeEnum::INVALID_REQUEST
        );
    }
}
