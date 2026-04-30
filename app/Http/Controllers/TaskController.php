<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\GetUserTaskAction;
use TimeManagement\Actions\ShowTaskAction;
use TimeManagement\Actions\StoreTaskAction;
use TimeManagement\Actions\UpdateTaskAction;
use TimeManagement\Http\Requests\StoreTaskRequest;
use TimeManagement\Http\Requests\UpdateTaskRequest;
use TimeManagement\Http\Resources\TaskResource;
use TimeManagement\Models\Task;

class TaskController extends Controller
{
    public function index(GetUserTaskAction $action): JsonResponse
    {
        $this->authorize("viewAny", Task::class);

        $tasks = $action->execute(request()->user());

        return response()->json([
            "data" => TaskResource::collection($tasks),
        ]);
    }

    public function show(Task $task, ShowTaskAction $action): JsonResponse
    {
        $this->authorize("view", $task);

        $task = $action->execute($task);

        return response()->json([
            "data" => new TaskResource($task),
        ]);
    }

    public function store(StoreTaskRequest $request, StoreTaskAction $action): JsonResponse
    {
        $this->authorize("create", Task::class);

        $task = $action->execute($request->user(), $request->validated());

        return response()->json([
            "message" => __("tasks.created"),
            "data" => new TaskResource($task),
        ], Status::HTTP_CREATED);
    }

    public function update(UpdateTaskRequest $request, Task $task, UpdateTaskAction $action): JsonResponse
    {
        $this->authorize("update", $task);

        $task = $action->execute($task, $request->validated(), $request->user());

        return response()->json([
            "message" => __("tasks.updated"),
            "data" => new TaskResource($task),
        ]);
    }
}
