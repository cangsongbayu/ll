<?php

namespace App\Http\Resources;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

class BaseJsonResource extends JsonResource
{
    protected function hashId($id): string
    {
        return Hashids::encode($id);
    }

    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        $data = parent::toArray($request);

        foreach ($data as $key => $value) {
            if (str_ends_with($key, '_id') || $key === 'id') {
                $data[$key] = $this->hashId($value);
            } else if (str_ends_with($key, '_ids')) {
                $data[$key] = collect($value)->map(fn($id) => $this->hashId($id));
            }
        }

        return $data;
    }
}
