<?php

declare(strict_types=1);

namespace TimeManagement\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "color" => $this->color,
            "created_at" => $this->created_at?->toISOString(),
            "updated_at" => $this->updated_at?->toISOString(),
        ];
    }
}
