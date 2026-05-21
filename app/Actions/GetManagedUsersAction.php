<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use TimeManagement\Enums\Role;
use TimeManagement\Models\User;

class GetManagedUsersAction
{
    public function execute(int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->role(Role::User->value)
            ->orderBy("id")
            ->paginate($perPage);
    }
}
