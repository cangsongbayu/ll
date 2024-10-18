<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaymentServiceProvider
 *
 * @property int $id
 * @property string $name
 * @property bool $is_open_for_business
 * @property float $balance
 * @property float $deposit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class PaymentServiceProvider extends BaseModel
{
	use SoftDeletes;

	protected $casts = [
		'is_open_for_business' => 'bool',
		'balance' => 'float',
		'deposit' => 'float'
	];

	protected $fillable = [
		'name',
		'is_open_for_business',
		'balance',
		'deposit'
	];
}
