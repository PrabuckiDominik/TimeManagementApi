<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Carbon\CarbonImmutable;
use TimeManagement\DTO\UpcomingDeadlinesDto;
use TimeManagement\DTO\UpcomingDeadlineTaskDto;
use TimeManagement\Enums\TaskStatus;
use TimeManagement\Models\User;

class GetUpcomingDeadlinesAction
{
    public function execute(
        User $user,
        CarbonImmutable $now,
    ): UpcomingDeadlinesDto {
        $start = $now->startOfDay();

        $end = $now
            ->addDays(7)
            ->endOfDay();

        $tasks = $user->tasks()
            ->with("category")
            ->whereNotNull("due_date")
            ->betweenDates("due_date", $start, $end)
            ->where("status", "!=", TaskStatus::DONE)
            ->orderBy("due_date")
            ->get()
            ->map(
                fn($task): UpcomingDeadlineTaskDto => new UpcomingDeadlineTaskDto(
                    id: $task->id,
                    name: $task->name,
                    dueDate: $task->due_date?->toISOString(),
                    isOverdue: $task->isOverdue(),
                    category: $task->category
                        ? [
                            "id" => $task->category->id,
                            "title" => $task->category->title,
                            "color" => $task->category->color,
                        ]
                        : null,
                ),
            )
            ->values()
            ->all();

        return new UpcomingDeadlinesDto(
            periodStart: $start->toDateString(),
            periodEnd: $end->toDateString(),
            tasks: $tasks,
        );
    }
}
