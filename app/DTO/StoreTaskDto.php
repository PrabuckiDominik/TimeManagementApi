<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;

class StoreTaskDto
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?TaskPriority $priority,
        public ?TaskStatus $status,
        public ?string $due_date,
        public ?int $category_id,
    ) {}
}
