<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Task;

class DeleteTaskAction
{
    public function execute(Task $task): void
    {
        $task->delete();
    }
}
