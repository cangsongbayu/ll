<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 * Class Currency
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $symbol
 * @property bool $is_base_currency
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Currency extends BaseModel
{
	protected $casts = [
		'is_base_currency' => 'bool',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
	];

	protected $fillable = [
		'code',
		'name',
		'symbol',
		'is_base_currency'
	];

    /**
     * 确保只有一个基准货币
     */
    public function ensureSingleBaseCurrency(): void
    {
        if ($this->is_base_currency) {
            Currency::where('is_base_currency', true)->update(['is_base_currency' => false]);
        }
    }
}
