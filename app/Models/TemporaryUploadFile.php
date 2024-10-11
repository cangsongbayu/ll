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
    ];

    protected $fillable = [
        'path',
        'data',
    ];
}
