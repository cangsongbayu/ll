<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 * Class PaymentType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $valid_amount
 * @property int $order_ttl
 * @property string $business_hours
 * @property bool $is_open_for_business
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PaymentType extends BaseModel
{

	protected $casts = [
		// 'order_ttl' => 'int',
		'is_open_for_business' => 'bool',
	];

	protected $fillable = [
		'name',
		'code',
		'valid_amount',
		'order_ttl',
		'business_hours',
		'is_open_for_business'
	];
}
