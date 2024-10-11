<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Models\TemporaryUploadFile;
use App\Http\Requests\Upload\HandleRequest;
use Carbon\Carbon;
use App\Enums\ApiErrorCodeEnum;


class UploadController extends Controller
{
    //
    public function handle(HandleRequest $request)
    {
        $user = auth()->user();

        // 确保模型实现了 HasMedia 接口
        if (!$user instanceof \Spatie\MediaLibrary\HasMedia) {
             // 返回错误信息
             return ApiResponse::fail(
                '用户不允许上传',
                ApiErrorCodeEnum::INVALID_REQUEST,
            );
        }

        $file = $request->file('file');
        $date = Carbon::now()->format('Y/m/d');
        $path = $file->store("uploads/{$date}", 'local');
        $temporaryUploadFile = TemporaryUploadFile::create(['path' => $path, 'data' => $request->input('context')]);
        
        // 使用 Medialibrary 存储文件的元数据，而不实际存储文件
        $user->addMedia($file)
          ->usingFileName(basename($path))
          ->preservingOriginal() //保存文件信息，不保存文件
          ->toMediaCollection('uploads');

        return ApiResponse::success(
            [
                'context' => [
                    'path' => $temporaryUploadFile->path,
                    ...$temporaryUploadFile->data,
                ],
            ],
            ApiMessageEnum::UPLOAD_SUCCESS->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
