<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Deposit
 *
 * @property int $id
 * @property string $depositable_type
 * @property int $depositable_id
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
class Deposit extends BaseModel
{
	protected $casts = [
		'depositable_id' => 'int',
		'currency_id' => 'int',
		'amount' => 'float',
		'exchange_rate' => 'float',
		'base_currency_id' => 'int',
		'base_amount' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
	];

	protected $fillable = [
		'depositable_type',
		'depositable_id',
		'trade_no',
		'currency_id',
		'amount',
		'exchange_rate',
		'base_currency_id',
		'note'
	];

    public function depositable(): MorphTo
    {
        return $this->morphTo();
    }
}
