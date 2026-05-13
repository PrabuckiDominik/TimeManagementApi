<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class PriorityDistributionDto
{
    public function __construct(
        public string $priority,
        public int $count,
    ) {}
}
