<?php

namespace App\Models;

use App\Models\Traits\HasHashID;
use Spatie\Activitylog\Models\Activity;
use App\Models\Traits\DateSerializableTrait;

class ActivityLog extends Activity
{
    use HasHashID, DateSerializableTrait;

    protected $casts = [
        'properties' => 'array',
    ];
}
