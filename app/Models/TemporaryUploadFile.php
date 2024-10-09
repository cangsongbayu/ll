<?php

namespace App\Models;

/**
 * Class TemporaryUploadFile
 *
 * @property int $id
 * @property array $data
 *
 * @package App\Models
 */
class TemporaryUploadFile extends BaseModel
{
    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'path',
        'data',
    ];
}
