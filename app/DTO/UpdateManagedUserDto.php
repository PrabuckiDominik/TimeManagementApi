<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class UpdateManagedUserDto
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public bool $hasName,
        public bool $hasEmail,
    ) {}
}
