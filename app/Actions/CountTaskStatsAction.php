<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Carbon\CarbonImmutable;
use TimeManagement\DTO\TaskStatsDto;
use TimeManagement\Models\User;

class CountTaskStatsAction
{
    public function execute(
        User $user,
        CarbonImmutable $now,
    ): TaskStatsDto {
        return new TaskStatsDto(
            total: $user->totalTasksCount(),
            completed: $user->completedTasksCount(),
            inProgress: $user->inProgressTasksCount(),
            todo: $user->todoTasksCount(),
            overdue: $user->overdueTasksCount($now),
        );
    }
}
