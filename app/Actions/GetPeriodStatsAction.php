<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Carbon\CarbonImmutable;
use TimeManagement\DTO\PeriodStatsDto;
use TimeManagement\Models\User;

class GetPeriodStatsAction
{
    public function execute(
        User $user,
        CarbonImmutable $start,
        CarbonImmutable $end,
        CarbonImmutable $now,
    ): PeriodStatsDto {
        return new PeriodStatsDto(
            periodStart: $start->toDateString(),
            periodEnd: $end->toDateString(),
            createdTasks: $user->tasks()
                ->betweenDates("created_at", $start, $end)
                ->count(),
            completed: $user->tasks()
                ->betweenDates("completed_at", $start, $end)
                ->count(),
            dueTasks: $user->tasks()
                ->betweenDates("due_date", $start, $end)
                ->count(),
            todo: $user->tasks()
                ->todo()
                ->betweenDates("due_date", $start, $end)
                ->count(),
            inProgress: $user->tasks()
                ->inProgress()
                ->betweenDates("due_date", $start, $end)
                ->count(),
            overdue: $user->tasks()
                ->overdue($now)
                ->betweenDates("due_date", $start, $end)
                ->count(),
        );
    }
}
