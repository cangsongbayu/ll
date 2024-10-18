<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MerchantRate
 *
 * @property int $id
 * @property int $payment_type_id
 * @property int $merchant_id
 * @property float $rate
 * @property float $platform_rate
 * @property float $rebate
 * @property bool $is_open_for_business
 * @property string $valid_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property mixed $merchant
 *
 * @package App\Models
 */
class MerchantRate extends BaseModel
{
	use SoftDeletes;

	protected $casts = [
		'payment_type_id' => 'int',
		'merchant_id' => 'int',
		'rate' => 'float',
		'platform_rate' => 'float',
		'rebate' => 'float',
		'is_open_for_business' => 'bool',
	];

	protected $fillable = [
		'payment_type_id',
		'merchant_id',
		'rate',
		'platform_rate',
		'is_open_for_business'
	];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
