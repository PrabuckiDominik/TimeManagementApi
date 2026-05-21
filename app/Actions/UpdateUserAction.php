<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateUserDto;
use TimeManagement\Models\User;

class UpdateUserAction
{
    public function execute(User $user, UpdateUserDto $dto): User
    {
        $old = $user->only([
            "name",
        ]);

        $user->update($dto->toArray());

        $user->refresh();

        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event("updated")
            ->withProperties([
                "old" => $old,
                "new" => $user->only([
                    "name",
                ]),
            ])
            ->log("Updated profile");

        return $user;
    }
}
