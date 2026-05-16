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
            "completion_trend" => [
                "period_start" => $this->completionTrend->periodStart,
                "period_end" => $this->completionTrend->periodEnd,
                "days" => collect($this->completionTrend->days)
                    ->map(fn($day): array => [
                        "date" => $day->date,
                        "count" => $day->count,
                    ])
                    ->values()
                    ->all(),
            ],
            "upcoming_deadlines" => [
                "period_start" => $this->upcomingDeadlines->periodStart,
                "period_end" => $this->upcomingDeadlines->periodEnd,
                "tasks" => collect($this->upcomingDeadlines->tasks)
                    ->map(fn($task): array => [
                        "id" => $task->id,
                        "name" => $task->name,
                        "due_date" => $task->dueDate,
                        "is_overdue" => $task->isOverdue,
                        "category" => $task->category,
                    ])
                    ->values()
                    ->all(),
            ],
        ];
    }
}
