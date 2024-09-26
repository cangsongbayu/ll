<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 * Class MerchantPrepayment
 *
 * @property int $id
 * @property int $merchant_id
 * @property string $trade_no
 * @property int $currency_id
 * @property float $amount
 * @property float $exchange_rate
 * @property int $base_currency_id
 * @property float $base_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property mixed $merchant
 *
 * @package App\Models
 */
class MerchantPrepayment extends BaseModel
{
	protected $casts = [
		'merchant_id' => 'int',
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
		'currency_id',
		'amount',
		'exchange_rate',
		'base_currency_id',
	];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class)->withTrashed();
    }
}
