<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class StoreCategoryDto
{
    public function __construct(
        public string $title,
        public ?string $color,
    ) {}
}
