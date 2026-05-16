<?php

declare(strict_types=1);

namespace TimeManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use TimeManagement\Enums\Role;
use TimeManagement\Models\Category;
use TimeManagement\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Category $category): bool
    {
        if (
            $user->hasRole(Role::Administrator->value) ||
            $user->hasRole(Role::SuperAdministrator->value)
        ) {
            return true;
        }

        return $category->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Category $category): bool
    {
        return $this->view($user, $category);
    }

    public function delete(User $user, Category $category): bool
    {
        return $this->view($user, $category);
    }
}
