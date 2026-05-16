<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Carbon\CarbonImmutable;
use TimeManagement\DTO\CompletionTrendDayDto;
use TimeManagement\DTO\CompletionTrendDto;
use TimeManagement\Models\User;

class GetCompletionTrendAction
{
    public function execute(
        User $user,
        CarbonImmutable $now,
    ): CompletionTrendDto {
        $start = $now
            ->subDays(6)
            ->startOfDay();

        $end = $now->endOfDay();

        $completedTasks = $user->tasks()
            ->selectRaw("DATE(completed_at) as date")
            ->selectRaw("COUNT(*) as count")
            ->whereNotNull("completed_at")
            ->betweenDates("completed_at", $start, $end)
            ->groupByRaw("DATE(completed_at)")
            ->pluck("count", "date");

        $days = [];

        foreach (range(0, 6) as $offset) {
            $date = $start
                ->addDays($offset)
                ->toDateString();

            $days[] = new CompletionTrendDayDto(
                date: $date,
                count: $completedTasks[$date] ?? 0,
            );
        }

        return new CompletionTrendDto(
            periodStart: $start->toDateString(),
            periodEnd: $end->toDateString(),
            days: $days,
        );
    }
}
