<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 * Class MerchantBill
 *
 * @property int $id
 * @property int $merchant_id
 * @property int $type
 * @property string $trade_no
 * @property int $currency_id
 * @property float $amount
 * @property float $exchange_rate
 * @property int $base_currency_id
 * @property float $base_amount
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MerchantBill extends BaseModel
{
	protected $casts = [
		'merchant_id' => 'int',
		'type' => 'int',
		'currency_id' => 'int',
		'amount' => 'float',
		'exchange_rate' => 'float',
		'base_currency_id' => 'int',
		'base_amount' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
	];

	protected $fillable = [
		'merchant_id',
		'type',
		'trade_no',
		'currency_id',
		'amount',
		'exchange_rate',
		'base_currency_id',
		'base_amount',
		'note'
	];
}
