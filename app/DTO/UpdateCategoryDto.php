<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class UpdateCategoryDto
{
    public function __construct(
        public ?string $title,
        public ?string $color,
    ) {}
}
