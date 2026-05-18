<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\User;

class DeleteManagedUserAction
{
    public function execute(User $user): void
    {
        $user->delete();
    }
}
