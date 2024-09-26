<?php

namespace App\Models;

use App\Models\Traits\HasHashID;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    use HasHashID;

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
