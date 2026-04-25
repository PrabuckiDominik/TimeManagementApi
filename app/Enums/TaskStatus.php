<?php

declare(strict_types=1);

namespace TimeManagement\Enums;

enum TaskStatus: string
{
    case TODO = "todo";
    case IN_PROGRESS = "in_progress";
    case DONE = "done";

    public function label(): string
    {
        return __("enums.task_status.$this->value");
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
