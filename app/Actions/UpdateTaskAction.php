<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateTaskDto;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class UpdateTaskAction
{
    public function execute(Task $task, UpdateTaskDto $dto, User $user): Task
    {
        $data = $dto->toArray();

        if ($dto->hasCategoryId) {
            $data["category_id"] = $dto->category_id === null
                ? null
                : $user->categories()->findOrFail($dto->category_id)->id;
        }

        $task->update($data);

        return $task->load("category");
    }
}
