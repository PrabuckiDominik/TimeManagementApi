<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;

class UpdateTaskDto
{
    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?TaskPriority $priority,
        public ?TaskStatus $status,
        public ?string $due_date,
        public bool $hasCategoryId,
        public ?int $category_id,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            "name" => $this->name,
            "description" => $this->description,
            "priority" => $this->priority,
            "status" => $this->status,
            "due_date" => $this->due_date,
        ], fn($value) => $value !== null);
    }
}
