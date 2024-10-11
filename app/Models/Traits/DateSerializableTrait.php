<?php

namespace App\Models\Traits;

use DateTimeInterface;

trait DateSerializableTrait
{
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
