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
        return ApiResponse::success(
            [
                'file' => $temporaryUploadFile,
            ],
            ApiMessageEnum::UPLOAD_SUCCESS->getMessage(),
            ApiMessageShowTypeEnum::SUCCESS,
        );
    }
}
