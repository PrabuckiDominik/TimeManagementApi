<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class UpdateTaskAction
{
    public function execute(Task $task, array $data, User $user): Task
    {
        $data = $this->resolveCategory($data, $user);

        $task->update($data);

        return $task->load("category");
    }

    private function resolveCategory(array $data, User $user): array
    {
        if (!array_key_exists("category_id", $data)) {
            return $data;
        }

        if ($data["category_id"] === null) {
            return $data;
        }

        $data["category_id"] = $user->categories()
            ->findOrFail($data["category_id"])
            ->id;

        return $data;
    }
}
