<?php

namespace App\Helpers;

use App\Enums\ApiMessageShowTypeEnum;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiResponse
{
    public static function success($data, $message, $showType, $extends = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'show_type' => $showType,
            'api_result_code' => 'OK',
            'api_result_message' => '成功',
        ];

        if (filled($data)) {
            $response['data'] = $data;
        }

        return response()->json(array_merge($response, $extends), ResponseAlias::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public static function fail($errorMessage, $errorCode, $errors = [], $showType = ApiMessageShowTypeEnum::ERROR, $extends = []): JsonResponse
    {
        $response = [
            'success' => true,
            'error_message' => $errorMessage,
            'show_type' => $showType,
            'api_result_code' => 'FAILED',
            'api_result_message' => '失败',
            'error_code' => $errorCode,
            'errors' => $errors,
        ];

        return response()->json(array_merge($response, $extends), ResponseAlias::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
}
