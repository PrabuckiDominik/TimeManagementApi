<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class StoreTaskAction
{
    public function execute(User $user, array $data): Task
    {
        if (!empty($data["category_id"])) {
            $data["category_id"] = $user->categories()
                ->findOrFail($data["category_id"])
                ->id;
        }

        $data["user_id"] = $user->id;

        return Task::create($data)->load("category");
    }
}
