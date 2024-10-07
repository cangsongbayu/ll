<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Traits\HasHashID;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasSanctumPersonalAccessToken;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\HigherOrderCollectionProxy;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Supplier
 *
 * @property int $id
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string $username
 * @property string $password
 * @property int $max_token_count
 * @property bool $is_enable_tfa
 * @property string|null $tfa_secret
 * @property bool $is_open_for_business
 * @property float $balance
 * @property float $deposit
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property HigherOrderCollectionProxy|mixed $parent
 *
 * @package App\Models
 */
class Supplier extends BaseModel
{
	use Notifiable, SoftDeletes, HasSanctumPersonalAccessToken, Filterable, HasHashID, NodeTrait;

	protected $casts = [
		'_lft' => 'int',
		'_rgt' => 'int',
		'parent_id' => 'int',
        'password' => 'hashed',
		'email_verified_at' => 'datetime:Y-m-d H:i:s',
		'max_token_count' => 'int',
		'is_enable_tfa' => 'bool',
		'is_open_for_business' => 'bool',
		'balance' => 'float',
		'deposit' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
	];

	protected $hidden = [
		'password',
		'tfa_secret',
		'remember_token'
	];

	protected $fillable = [
		'parent_id',
		'name',
		'email',
		'username',
		'password',
		'max_token_count',
		'is_enable_tfa',
		'is_open_for_business',
	];

    protected $attributes = [
        'is_open_for_business' => true,
        'balance' => 0,
        'deposit' => 0,
        'max_token_count' => 1,
        'is_enable_tfa' => false,
    ];
}
