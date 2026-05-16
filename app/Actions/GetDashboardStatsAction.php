<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Carbon\CarbonImmutable;
use Carbon\Constants\UnitValue;
use TimeManagement\DTO\DashboardStatsDto;
use TimeManagement\Models\User;

readonly class GetDashboardStatsAction
{
    public function __construct(
        private CountTaskStatsAction $countTaskStats,
        private GetPriorityDistributionAction $priorityDistribution,
        private GetStatusDistributionAction $statusDistribution,
        private GetCategoryDistributionAction $categoryDistribution,
        private GetPeriodStatsAction $periodStats,
        private GetCompletionTrendAction $completionTrend,
        private GetUpcomingDeadlinesAction $upcomingDeadlines,
    ) {}

    public function execute(User $user): DashboardStatsDto
    {
        $now = CarbonImmutable::now();

        return new DashboardStatsDto(
            taskStats: $this->countTaskStats->execute($user, $now),
            priorityDistribution: $this->priorityDistribution->execute($user),
            statusDistribution: $this->statusDistribution->execute($user),
            categoryDistribution: $this->categoryDistribution->execute($user),
            weekly: $this->periodStats->execute(
                $user,
                $now->startOfWeek(UnitValue::MONDAY),
                $now->endOfWeek(UnitValue::SUNDAY),
                $now,
            ),
            monthly: $this->periodStats->execute(
                $user,
                $now->startOfMonth(),
                $now->endOfMonth(),
                $now,
            ),
            completionTrend: $this->completionTrend->execute(
                $user,
                $now,
            ),
            upcomingDeadlines: $this->upcomingDeadlines->execute(
                $user,
                $now,
            ),
        );
    }
}
