<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class DashboardStatsDto
{
    public function __construct(
        public TaskStatsDto $taskStats,
        /** @var array<PriorityDistributionDto> */
        public array $priorityDistribution,
        /** @var array<StatusDistributionDto> */
        public array $statusDistribution,
        /** @var array<CategoryDistributionDto> */
        public array $categoryDistribution,
        public PeriodStatsDto $weekly,
        public PeriodStatsDto $monthly,
        public CompletionTrendDto $completionTrend,
        public UpcomingDeadlinesDto $upcomingDeadlines,
    ) {}
}
