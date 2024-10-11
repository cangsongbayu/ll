<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Helpers\ApiResponse;
use App\Models\TemporaryUploadFile;
use App\Http\Requests\Upload\HandleRequest;
use Carbon\Carbon;

class UploadController extends Controller
{
    //
    public function handle(HandleRequest $request)
    {
        $file = $request->file('file');
        $date = Carbon::now()->format('Y/m/d');
        $path = $file->store("uploads/{$date}", 'local');
        $temporaryUploadFile = TemporaryUploadFile::create(['path' => $path, 'data' => $request->input('context')]);
        
        // 使用 Medialibrary 存储文件的元数据，而不实际存储文件
        
        $user = auth()->user();

        

         $temporaryUploadFile->addMedia($file)
                             ->preservingOriginal() // 保持文件信息，但不存储
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
