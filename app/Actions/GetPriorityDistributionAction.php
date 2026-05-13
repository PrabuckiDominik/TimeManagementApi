<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\PriorityDistributionDto;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Models\User;

class GetPriorityDistributionAction
{
    /**
     * @return array<int, PriorityDistributionDto>
     */
    public function execute(User $user): array
    {
        return collect(TaskPriority::cases())
            ->map(
                fn(TaskPriority $priority): PriorityDistributionDto => new PriorityDistributionDto(
                    priority: $priority->value,
                    count: $user->tasksByPriorityCount($priority),
                ),
            )
            ->values()
            ->all();
    }
}
