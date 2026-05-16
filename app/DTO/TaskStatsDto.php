<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class TaskStatsDto
{
    public function __construct(
        public int $total,
        public int $completed,
        public int $inProgress,
        public int $todo,
        public int $overdue,
    ) {}
}
