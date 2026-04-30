<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class UpdateUserDto
{
    public function __construct(
        public ?string $name,
        public ?string $email,
    ) {}
}
