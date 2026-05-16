<?php

declare(strict_types=1);

namespace TimeManagement\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeriodStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "period_start" => $this->periodStart,
            "period_end" => $this->periodEnd,
            "created_tasks" => $this->createdTasks,
            "completed" => $this->completed,
            "due_tasks" => $this->dueTasks,
            "todo" => $this->todo,
            "in_progress" => $this->inProgress,
            "overdue" => $this->overdue,
        ];
    }
}
