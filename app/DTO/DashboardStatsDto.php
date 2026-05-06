<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class DashboardStatsDto
{
    public function __construct(
        public int $totalTasks,
        public int $completed,
        public int $inProgress,
        public int $toDo,
        public int $overdue,
        public array $priorityDistribution,
        public array $statusDistribution,
        public array $categoryDistribution,
        public array $weeklyStats,
        public array $monthlyStats,
        public array $upcomingDeadlines,
    ) {}
}
