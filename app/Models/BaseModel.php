<?php

namespace App\Models;

use App\Models\Traits\HasHashID;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Filterable, HasHashID;
}
