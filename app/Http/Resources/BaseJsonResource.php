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
        if (isset($data['id'])) {
            $data['id'] = $this->hashId($data['id']);
        }
        return $data;
    }
}
