<?php

declare(strict_types=1);

namespace TimeManagement\Enums;

enum TaskPriority: string
{
    case LOW = "low";
    case MEDIUM = "medium";
    case HIGH = "high";

    public function label(): string
    {
        return __("enums.task_priority.$this->value");
    }

    public static function options(): array
    {
        return array_map(
            fn(self $priority) => [
                "label" => $priority->label(),
                "value" => $priority->value,
            ],
            self::cases(),
        );
    }
}
