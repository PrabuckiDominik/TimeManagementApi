<?php

declare(strict_types=1);

namespace TimeManagement\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "total_tasks" => $this->totalTasks,
            "completed" => $this->completed,
            "in_progress" => $this->inProgress,
            "to_do" => $this->toDo,
            "overdue" => $this->overdue,
            "priority_distribution" => $this->priorityDistribution,
            "status_distribution" => $this->statusDistribution,
            "category_distribution" => $this->categoryDistribution,
            "weekly" => $this->weeklyStats,
            "monthly" => $this->monthlyStats,
            "upcoming_deadlines" => $this->upcomingDeadlines,
        ];
    }
}
