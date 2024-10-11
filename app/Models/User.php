<?php

namespace App\Models;

use App\Enums\ActivityLogEventEnum;
use App\Enums\ActivityLogNameEnum;
use App\Models\Traits\HasHashID;
use App\Models\Traits\HasSanctumPersonalAccessToken;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Traits\DateSerializableTrait;

/**
 * @property mixed $is_enable_tfa
 * @property mixed|null $tfa_secret
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, SoftDeletes, HasSanctumPersonalAccessToken, LogsActivity, Filterable, HasHashID, DateSerializableTrait, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'is_enable_tfa',
        'max_token_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'tfa_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_enable_tfa' => 'boolean',
        'password' => 'hashed',
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
            ActivityLogEventEnum::CREATED->value => '创建了用户',
            default => $eventName,
        };
    }
}
