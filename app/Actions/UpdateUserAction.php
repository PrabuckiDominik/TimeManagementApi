<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateUserDto;
use TimeManagement\Models\User;

class UpdateUserAction
{
    public function execute(User $user, UpdateUserDto $dto): User
    {
        $user->update(
            $dto->toArray(),
        );

        return $user->refresh();
    }
}
