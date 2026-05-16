<?php

declare(strict_types=1);

namespace TimeManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use TimeManagement\Enums\Role;
use TimeManagement\Models\Tag;
use TimeManagement\Models\User;

class TagPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Tag $tag): bool
    {
        if (
            $user->hasRole(Role::Administrator->value) ||
            $user->hasRole(Role::SuperAdministrator->value)
        ) {
            return true;
        }

        return $tag->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Tag $tag): bool
    {
        return $this->view($user, $tag);
    }

    public function delete(User $user, Tag $tag): bool
    {
        return $this->view($user, $tag);
    }
}
