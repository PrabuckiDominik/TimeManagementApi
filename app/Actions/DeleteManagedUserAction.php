<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\User;

class DeleteManagedUserAction
{
    public function execute(User $user): void
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->event("deleted")
            ->withProperties([
                "user_id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ])
            ->log("Deleted user");

        $user->delete();
    }
}
