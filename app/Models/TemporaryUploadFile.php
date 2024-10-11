<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

/**
 * Class TemporaryUploadFile
 *
 * @property int $id
 * @property array $data
 *
 * @package App\Models
 */
class TemporaryUploadFile extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'path',
        'data',
    ];
}
