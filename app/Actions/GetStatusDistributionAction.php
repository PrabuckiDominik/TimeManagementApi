<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\StatusDistributionDto;
use TimeManagement\Enums\TaskStatus;
use TimeManagement\Models\User;

class GetStatusDistributionAction
{
    /**
     * @return array<int, StatusDistributionDto>
     */
    public function execute(User $user): array
    {
        return collect(TaskStatus::cases())
            ->map(
                fn(TaskStatus $status): StatusDistributionDto => new StatusDistributionDto(
                    status: $status->value,
                    count: $user->tasksByStatusCount($status),
                ),
            )
            ->values()
            ->all();
    }
}
