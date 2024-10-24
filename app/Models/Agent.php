<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\ActivityLogEventEnum;
use App\Enums\ActivityLogNameEnum;
use App\Models\Traits\HasHashID;
use App\Models\Traits\HasSanctumPersonalAccessToken;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Traits\DateSerializableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
/**
 * Class Agent
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string $username
 * @property string $password
 * @property int $max_token_count
 * @property bool $is_enable_tfa
 * @property string|null $tfa_secret
 * @property string|null $allowed_ip_addresses
 * @property float $balance
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Agent extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, HasSanctumPersonalAccessToken, LogsActivity, Filterable, HasHashID, DateSerializableTrait, InteractsWithMedia;

	protected $casts = [
        'password' => 'hashed',
		// 'max_token_count' => 'int',
		'is_enable_tfa' => 'bool',
		// 'balance' => 'float',
	];

	protected $hidden = [
		'password',
		'tfa_secret',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'username',
		'password',
		'max_token_count',
		'is_enable_tfa',
		'allowed_ip_addresses',
	];

    protected $attributes = [
        'balance' => 0,
        'max_token_count' => 1,
        'is_enable_tfa' => false,
    ];

    /**
     * 需要自动记录的事件
     *
     * @var string[]
     */
    protected static array $recordEvents = ['created'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'username', 'is_enable_tfa', 'max_token_count'])
            ->logOnlyDirty()
            ->useLogName(ActivityLogNameEnum::USER->value);
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return match ($eventName) {
            ActivityLogEventEnum::CREATED->value => '创建了代理',
            default => $eventName,
        };
    }
}
