<?php

namespace App\Exceptions;

use App\Enums\ActivityLogEventEnum;
use App\Enums\ActivityLogNameEnum;
use App\Enums\ApiErrorCodeEnum;
use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class LoginFailedException extends Exception
{
    //
    protected array $extraData;

    public function __construct(string $message = "", int $code = 0, $extraData = [], ?Throwable $previous = null)
    {
        $this->extraData = $extraData;
        parent::__construct($message, $code, $previous);
    }

    public function render(): JsonResponse
    {
        $properties = $this->extraData;

        activity()
            ->inLog(ActivityLogNameEnum::LOGIN->value)
            ->event(ActivityLogEventEnum::LOGIN_FAILURE->value)
            ->withProperties($properties)
            ->log($this->getMessage());

        return ApiResponse::fail(
            ApiErrorCodeEnum::LOGIN_FAILED->getErrorMessage(),
            ApiErrorCodeEnum::LOGIN_FAILED->value,
        );
    }
}
