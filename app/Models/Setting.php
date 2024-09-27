<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\SettingCategoryEnum;
use Carbon\Carbon;

/**
 * Class Setting
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $category
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Setting extends BaseModel
{
	protected $fillable = [
		'key',
		'value',
		'category',
		'description'
	];

    protected $casts = [
        'category' => SettingCategoryEnum::class,
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
