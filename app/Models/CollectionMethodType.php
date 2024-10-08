<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 * Class CollectionMethodType
 *
 * @property int $id
 * @property string $payment_type_ids
 * @property string $name
 * @property int $sort
 * @property string $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CollectionMethodType extends BaseModel
{
	protected $casts = [
		'sort' => 'int',
        'data' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
	];

	protected $fillable = [
		'payment_type_ids',
		'name',
		'sort',
		'data'
	];
}
