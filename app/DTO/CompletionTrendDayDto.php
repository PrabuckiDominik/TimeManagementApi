<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class CompletionTrendDayDto
{
    public function __construct(
        public string $date,
        public int $count,
    ) {}
}
