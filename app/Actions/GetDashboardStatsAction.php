<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Carbon\CarbonImmutable;
use Carbon\Constants\UnitValue;
use TimeManagement\DTO\DashboardStatsDto;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;
use TimeManagement\Models\User;

class GetDashboardStatsAction
{
    public function execute(User $user): DashboardStatsDto
    {
        $now = CarbonImmutable::now();

        return new DashboardStatsDto(
            totalTasks: $user->tasks()->count(),
            completed: $this->countByStatus($user, TaskStatus::DONE),
            inProgress: $this->countByStatus($user, TaskStatus::IN_PROGRESS),
            toDo: $this->countByStatus($user, TaskStatus::TODO),
            overdue: $this->countOverdue($user, $now),
            priorityDistribution: $this->priorityDistribution($user),
            statusDistribution: $this->statusDistribution($user),
            categoryDistribution: $this->categoryDistribution($user),
            weeklyStats: $this->periodStats(
                $user,
                $now->startOfWeek(UnitValue::MONDAY),
                $now->endOfWeek(UnitValue::SUNDAY),
                $now,
            ),
            monthlyStats: $this->periodStats($user, $now->startOfMonth(), $now->endOfMonth(), $now),
            upcomingDeadlines: $this->upcomingDeadlines($user, $now),
        );
    }

    private function countByStatus(User $user, TaskStatus $status): int
    {
        return $user->tasks()
            ->where("status", $status->value)
            ->count();
    }

    private function countOverdue(User $user, CarbonImmutable $now): int
    {
        return $user->tasks()
            ->whereNotNull("due_date")
            ->where("due_date", "<", $now)
            ->where("status", "!=", TaskStatus::DONE->value)
            ->count();
    }

    private function priorityDistribution(User $user): array
    {
        return array_map(
            fn(TaskPriority $priority): array => [
                "priority" => $priority->value,
                "count" => $user->tasks()
                    ->where("priority", $priority->value)
                    ->count(),
            ],
            TaskPriority::cases(),
        );
    }

    private function statusDistribution(User $user): array
    {
        return array_map(
            fn(TaskStatus $status): array => [
                "status" => $status->value,
                "count" => $this->countByStatus($user, $status),
            ],
            TaskStatus::cases(),
        );
    }

    private function categoryDistribution(User $user): array
    {
        $categories = $user->categories()
            ->whereHas("tasks")
            ->withCount("tasks")
            ->orderBy("categories.title")
            ->get()
            ->map(fn($category): array => [
                "category_id" => $category->id,
                "title" => $category->title,
                "color" => $category->color,
                "count" => $category->tasks_count,
            ]);

        $uncategorizedTasks = $user->tasks()
            ->whereNull("category_id")
            ->count();

        if ($uncategorizedTasks > 0) {
            $categories->push([
                "category_id" => null,
                "title" => null,
                "color" => null,
                "count" => $uncategorizedTasks,
            ]);
        }

        return $categories
            ->values()
            ->all();
    }

    private function periodStats(
        User $user,
        CarbonImmutable $start,
        CarbonImmutable $end,
        CarbonImmutable $now,
    ): array {
        return [
            "period_start" => $start->toDateString(),
            "period_end" => $end->toDateString(),
            "created_tasks" => $user->tasks()
                ->whereBetween("created_at", [$start, $end])
                ->count(),
            "completed" => $user->tasks()
                ->whereBetween("completed_at", [$start, $end])
                ->count(),
            "due_tasks" => $user->tasks()
                ->whereBetween("due_date", [$start, $end])
                ->count(),
            "to_do" => $user->tasks()
                ->where("status", TaskStatus::TODO->value)
                ->whereBetween("due_date", [$start, $end])
                ->count(),
            "in_progress" => $user->tasks()
                ->where("status", TaskStatus::IN_PROGRESS->value)
                ->whereBetween("due_date", [$start, $end])
                ->count(),
            "overdue" => $user->tasks()
                ->whereNotNull("due_date")
                ->whereBetween("due_date", [$start, $end])
                ->where("due_date", "<", $now)
                ->where("status", "!=", TaskStatus::DONE->value)
                ->count(),
        ];
    }

    private function upcomingDeadlines(User $user, CarbonImmutable $now): array
    {
        $start = $now->startOfDay();
        $end = $now->addDays(7)->endOfDay();

        return [
            "period_start" => $start->toDateString(),
            "period_end" => $end->toDateString(),
            "tasks" => $user->tasks()
                ->with("category")
                ->whereNotNull("due_date")
                ->whereBetween("due_date", [$start, $end])
                ->where("status", "!=", TaskStatus::DONE->value)
                ->orderBy("due_date")
                ->get()
                ->map(fn($task): array => [
                    "id" => $task->id,
                    "name" => $task->name,
                    "due_date" => $task->due_date?->toISOString(),
                    "is_overdue" => $task->isOverdue(),
                    "category" => $task->category ? [
                        "id" => $task->category->id,
                        "title" => $task->category->title,
                        "color" => $task->category->color,
                    ] : null,
                ])
                ->values()
                ->all(),
        ];
    }
}
