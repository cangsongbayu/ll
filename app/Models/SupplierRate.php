<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SupplierRate
 * 
 * @property int $id
 * @property int $payment_type_id
 * @property int $supplier_id
 * @property float $rate
 * @property bool $is_open_for_business
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class SupplierRate extends BaseModel
{
	use SoftDeletes;
	protected $table = 'supplier_rates';
	protected $perPage = 20;

	protected $casts = [
		'payment_type_id' => 'int',
		'supplier_id' => 'int',
		'rate' => 'float',
		'is_open_for_business' => 'bool'
	];

	protected $fillable = [
		'payment_type_id',
		'supplier_id',
		'rate',
		'is_open_for_business'
	];
}
