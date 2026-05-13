<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class UpcomingDeadlinesDto
{
    /**
     * @param array<UpcomingDeadlineTaskDto> $tasks
     */
    public function __construct(
        public string $periodStart,
        public string $periodEnd,
        public array $tasks,
    ) {}
}
