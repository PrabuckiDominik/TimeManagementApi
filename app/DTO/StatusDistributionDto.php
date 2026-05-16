<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class StatusDistributionDto
{
    public function __construct(
        public string $status,
        public int $count,
    ) {}
}
