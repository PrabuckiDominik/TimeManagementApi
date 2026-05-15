<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateTaskDto;
use TimeManagement\Enums\TaskStatus;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class UpdateTaskAction
{
    public function execute(Task $task, UpdateTaskDto $dto, User $user): Task
    {
        $data = $dto->toArray();

        if ($dto->status !== null) {
            if ($dto->status === TaskStatus::DONE && $task->status !== TaskStatus::DONE) {
                $data["completed_at"] = now();
            }

            if ($dto->status !== TaskStatus::DONE) {
                $data["completed_at"] = null;
            }
        }

        if ($dto->hasCategoryId) {
            $data["category_id"] = $dto->category_id === null
                ? null
                : $user->categories()->findOrFail($dto->category_id)->id;
        }

        $task->update($data);

        if ($dto->hasTagIds) {
            if ($dto->tag_ids === null) {
                $task->tags()->sync([]);
            } else {
                $tagIds = $user->tags()
                    ->whereIn("id", $dto->tag_ids)
                    ->pluck("id")
                    ->toArray();

                $task->tags()->sync($tagIds);
            }
        }

        return $task->refresh()->load(["category", "tags"]);
    }
}
