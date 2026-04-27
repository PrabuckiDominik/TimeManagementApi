<?php

declare(strict_types=1);

namespace TimeManagement\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "priority" => $this->priority->value,
            "status" => $this->status->value,
            "due_date" => $this->due_date?->toISOString(),
            "completed_at" => $this->completed_at?->toISOString(),
            "is_overdue" => $this->isOverdue(),
            "category" => $this->whenLoaded("category", fn() => [
                "id" => $this->category->id,
                "title" => $this->category->title,
                "color" => $this->category->color,
            ]),
            "created_at" => $this->created_at->toISOString(),
            "updated_at" => $this->updated_at->toISOString(),
        ];
    }
}
