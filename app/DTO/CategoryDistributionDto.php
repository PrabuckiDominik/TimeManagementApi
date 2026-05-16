<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class CategoryDistributionDto
{
    public function __construct(
        public ?int $categoryId,
        public ?string $title,
        public ?string $color,
        public int $count,
    ) {}
}
