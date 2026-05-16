<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class UpdateUserDto
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
