<?php

declare(strict_types=1);

namespace TimeManagement\Policies;

use TimeManagement\Enums\Role;
use TimeManagement\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole([Role::Administrator->value, Role::SuperAdministrator->value]);
    }

    public function view(User $user, User $targetUser): bool
    {
        return $user->id === $targetUser->id
            || $user->hasRole([Role::Administrator->value, Role::SuperAdministrator->value]);
    }

    public function update(User $user, User $targetUser): bool
    {
        if ($targetUser->hasRole(Role::SuperAdministrator->value)) {
            return $user->hasRole(Role::SuperAdministrator->value);
        }

        if ($user->id === $targetUser->id) {
            return true;
        }

        return $user->hasRole(Role::Administrator->value)
            || $user->hasRole(Role::SuperAdministrator->value);
    }

    public function delete(User $user, User $targetUser): bool
    {
        if ($user->id === $targetUser->id) {
            return false;
        }

        if ($targetUser->hasRole(Role::SuperAdministrator->value)) {
            return $user->hasRole(Role::SuperAdministrator->value);
        }

        return $user->hasRole(Role::Administrator->value)
            || $user->hasRole(Role::SuperAdministrator->value);
    }

    public function manageAdmins(User $user): bool
    {
        return $user->hasRole(Role::SuperAdministrator->value);
    }
}
