<?php

declare(strict_types=1);

namespace TimeManagement\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "total_tasks" => $this->total,
            "completed" => $this->completed,
            "in_progress" => $this->inProgress,
            "to_do" => $this->todo,
            "overdue" => $this->overdue,
        ];
    }
}
