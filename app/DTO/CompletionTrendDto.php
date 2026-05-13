<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class CompletionTrendDto
{
    /**
     * @param array<CompletionTrendDayDto> $days
     */
    public function __construct(
        public string $periodStart,
        public string $periodEnd,
        public array $days,
    ) {}
}
