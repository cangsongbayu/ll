<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use App\Models\Traits\DateSerializableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @method static create(array $array)
 */
class Tenant extends BaseTenant implements TenantWithDatabase,HasMedia
{
    use HasDatabase, HasDomains, DateSerializableTrait, InteractsWithMedia;
}
