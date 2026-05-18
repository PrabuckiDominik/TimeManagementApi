<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateManagedUserDto;
use TimeManagement\Models\User;

class UpdateManagedUserAction
{
    public function execute(
        User $user,
        UpdateManagedUserDto $dto,
    ): User {
        $emailChanged =
            $dto->hasEmail
            && $dto->email !== null
            && $dto->email !== $user->email;

        if ($dto->hasName) {
            $user->name = $dto->name;
        }

        if ($dto->hasEmail) {
            $user->email = $dto->email;
        }

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();
        }

        return $user->refresh();
    }
}
