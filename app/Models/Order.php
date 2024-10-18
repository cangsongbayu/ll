<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 * Class Order
 *
 * @property int $id
 * @property int $payment_type_id
 * @property int $payment_channel_id
 * @property int $merchant_id
 * @property int|null $supplier_id
 * @property int|null $collection_method_id
 * @property string $trade_no
 * @property string $out_trade_no
 * @property int $status
 * @property float $amount
 * @property float $paid_amount
 * @property Carbon|null $paid_at
 * @property Carbon|null $cancel_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Order extends BaseModel
{
	protected $casts = [
		'payment_type_id' => 'int',
		'payment_channel_id' => 'int',
		'merchant_id' => 'int',
		'supplier_id' => 'int',
		'collection_method_id' => 'int',
		'status' => 'int',
		'amount' => 'float',
		'paid_amount' => 'float',
		'paid_at' => 'datetime',
		'cancel_at' => 'datetime'
	];

	protected $fillable = [
		'payment_type_id',
		'payment_channel_id',
		'merchant_id',
		'supplier_id',
		'collection_method_id',
		'trade_no',
		'out_trade_no',
		'status',
		'amount',
		'paid_amount',
		'paid_at',
		'cancel_at'
	];
}
