<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

readonly class UpcomingDeadlineTaskDto
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $dueDate,
        public bool $isOverdue,
        public ?array $category,
    ) {}
}
