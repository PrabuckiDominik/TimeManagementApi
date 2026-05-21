<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Task;

class DeleteTaskAction
{
    public function execute(Task $task): void
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($task)
            ->event("deleted")
            ->withProperties([
                "task_id" => $task->id,
                "name" => $task->name,
                "status" => $task->status->value,
                "priority" => $task->priority->value,
            ])
            ->log("Deleted task");

        $task->delete();
    }
}
