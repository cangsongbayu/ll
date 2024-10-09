<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Enums\SettingKeyEnum;
use App\Helpers\ApiResponse;
use App\Models\Setting;

class SiteNameController extends Controller
{
    //
    public function get()
    {
        $siteName = Setting::where('key', SettingKeyEnum::SITE_NAME->value)->value('value');
        return ApiResponse::success(
            ['site_name' => $siteName],
            ApiMessageEnum::INDEX->getMessage(),
            ApiMessageShowTypeEnum::SILENT,
        );
    }
}
