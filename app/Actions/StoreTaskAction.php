<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\StoreTaskDto;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class StoreTaskAction
{
    public function execute(User $user, StoreTaskDto $dto): Task
    {
        $data = [
            "name" => $dto->name,
            "description" => $dto->description,
            "priority" => $dto->priority ?? TaskPriority::MEDIUM,
            "status" => $dto->status ?? TaskStatus::TODO,
            "due_date" => $dto->due_date,
        ];

        if (!empty($dto->category_id)) {
            $data["category_id"] = $user->categories()->findOrFail($dto->category_id)->id;
        }

        $data["user_id"] = $user->id;

        if (($data["status"] ?? null) === TaskStatus::DONE) {
            $data["completed_at"] = now();
        }

        $task = Task::create($data);

        if (!empty($dto->tag_ids)) {
            $tagIds = $user->tags()->whereIn("id", $dto->tag_ids)->pluck("id")->toArray();
            $task->tags()->sync($tagIds);
        }

        return $task->load(["category", "tags"]);
    }
}
