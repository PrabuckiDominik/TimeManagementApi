<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Task;

class ShowTaskAction
{
    public function execute(Task $task): Task
    {
        return $task->load("category");
    }
}
