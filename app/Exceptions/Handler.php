<?php

namespace App\Exceptions;

use App\Enums\ApiErrorCodeEnum;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // 请求方法不允许
        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return $this->renderMethodNotAllowedHttpException($e);
        });

        // 请求的资源找不到
        $this->renderable(function (NotFoundHttpException $e) {
            return $this->renderNotFoundHttpException($e);
        });

        // 表单验证失败
        $this->renderable(function (ValidationException $e) {
            return $this->renderValidationException($e);
        });
    }

    // 请求方法不允许
    public function renderMethodNotAllowedHttpException(MethodNotAllowedHttpException $e): bool|\Illuminate\Http\JsonResponse
    {
        if (request()->expectsJson()) {
            return ApiResponse::fail(
                $e->getMessage(),
                ApiErrorCodeEnum::METHOD_NOT_ALLOWED_HTTP_EXCEPTION,
            );
        }
        return true;
    }

    // 请求的资源找不到
    public function renderNotFoundHttpException(NotFoundHttpException $e)
    {
        if (request()->expectsJson()) {
            return ApiResponse::fail(
                ApiErrorCodeEnum::NOT_FOUND_HTTP_EXCEPTION->getErrorMessage(),
                ApiErrorCodeEnum::NOT_FOUND_HTTP_EXCEPTION
            );
        }
    }

    // 表单验证失败
    public function renderValidationException(ValidationException $e): bool|\Illuminate\Http\JsonResponse
    {
        if (request()->expectsJson()) {
            return ApiResponse::fail(
                ApiErrorCodeEnum::VALIDATION_EXCEPTION->getErrorMessage(),
                ApiErrorCodeEnum::VALIDATION_EXCEPTION,
                $e->errors(),
            );
        }
        return true;
    }
}
