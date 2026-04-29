<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class RegisterUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
