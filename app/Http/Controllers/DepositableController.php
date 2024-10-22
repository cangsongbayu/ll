<?php

namespace App\Http\Controllers;

use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Enums\SettingKeyEnum;
use App\Helpers\ApiResponse;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use App\Http\Resources\DepositableCollection;

class DepositableController extends Controller
{
    //
    public function all()
    {
        $typeNames = [
            'merchant' => '商户',
            'supplier' => '供应商',
        ];

        $allowedDepositableTypes = Setting::getAllowedDepositableTypes();
        $allowedDepositableTypes = explode(',', $allowedDepositableTypes);
        $morphMap = Relation::morphMap();

        $depositableTypes = Arr::only($morphMap, $allowedDepositableTypes);

        $result = [];

        foreach ($depositableTypes as $type => $class) {
            $model = app($class);
            $items = $model::select(['id', 'name', 'deleted_at'])->withTrashed()->get();

            $result[] = [
                'type' => $type,
                'type_name' => $typeNames[$type],
                'items' => new DepositableCollection($items),
            ];
        }

        return ApiResponse::success(
            $result,
            ApiMessageEnum::GENERAL_SUCCESS->getMessage(),
            ApiMessageShowTypeEnum::SILENT,
        );
    }
}
