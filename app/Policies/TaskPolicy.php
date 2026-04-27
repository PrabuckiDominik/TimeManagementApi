<?php

declare(strict_types=1);

namespace TimeManagement\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use TimeManagement\Enums\Role;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task): bool
    {
        if ($user->hasRole(Role::Administrator->value) || $user->hasRole(Role::SuperAdministrator->value)) {
            return true;
        }

        return $task->user_id === $user->id;
    }

    public function update(User $user, Task $task): bool
    {
        return $this->view($user, $task);
    }

    public function delete(User $user, Task $task): bool
    {
        return $this->view($user, $task);
    }

    public function create(User $user): bool
    {
        return true;
    }
}
