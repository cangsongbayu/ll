<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class BaseModel extends Model
{
    use Filterable;
}
