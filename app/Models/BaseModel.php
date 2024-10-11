<?php

namespace App\Models;

use App\Models\Traits\HasHashID;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DateSerializableTrait;

class BaseModel extends Model
{
    use Filterable, HasHashID, DateSerializableTrait;
}
