<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class CollectionMethodType
 *
 * @property int $id
 * @property string $payment_type_ids
 * @property string $name
 * @property int $sort
 * @property array $data
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
	];

	protected $fillable = [
		'payment_type_ids',
		'name',
		'sort',
		'data'
	];

    protected function paymentTypeIds(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => explode(',', $value),
            set: fn (array $value) => implode(',', $value),
        );
    }
}
