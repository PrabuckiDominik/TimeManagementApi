<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Illuminate\Support\Collection;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class GetUserTaskAction
{
    public function execute(User $user): Collection
    {
        return Task::with(["category", "tags"])->where("user_id", $user->id)->latest()->get();
    }
}
