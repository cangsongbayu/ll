<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 * Class CollectionMethod
 *
 * @property int $id
 * @property int $collection_method_type_id
 * @property int $payment_type_id
 * @property int $supplier_id
 * @property string $name
 * @property float $daily_limit
 * @property int $daily_transaction_limit
 * @property bool $is_open_for_business
 * @property string $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CollectionMethod extends BaseModel
{
	protected $casts = [
		'collection_method_type_id' => 'int',
		'payment_type_id' => 'int',
		'supplier_id' => 'int',
		'daily_limit' => 'float',
		'daily_transaction_limit' => 'int',
		'is_open_for_business' => 'bool',
        'data' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
	];

	protected $fillable = [
		'collection_method_type_id',
		'payment_type_id',
		'supplier_id',
		'name',
		'daily_limit',
		'daily_transaction_limit',
		'is_open_for_business',
		'data'
	];
}
