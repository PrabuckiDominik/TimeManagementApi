<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class PeriodStatsDto
{
    public function __construct(
        public string $periodStart,
        public string $periodEnd,
        public int $createdTasks,
        public int $completed,
        public int $dueTasks,
        public int $todo,
        public int $inProgress,
        public int $overdue,
    ) {}
}
