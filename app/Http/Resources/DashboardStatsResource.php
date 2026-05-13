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
            "task_stats" => new TaskStatsResource($this->taskStats),
            "priority_distribution" => $this->priorityDistribution,
            "status_distribution" => $this->statusDistribution,
            "category_distribution" => $this->categoryDistribution,
            "weekly" => new PeriodStatsResource($this->weekly),
            "monthly" => new PeriodStatsResource($this->monthly),
            "completion_trend" => $this->completionTrend,
            "upcoming_deadlines" => $this->upcomingDeadlines,
        ];
    }
}
