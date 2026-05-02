<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class UpdateTagDto
{
    public function __construct(
        public ?string $name,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            "name" => $this->name,
        ], fn($value) => $value !== null);
    }
}
