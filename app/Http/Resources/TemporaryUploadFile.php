<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TemporaryUploadFile extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}