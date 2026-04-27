<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Http\Controllers\Controller;
use TimeManagement\Http\Resources\TaskResource;
use TimeManagement\Models\Task;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $user = request()->user();

        $tasks = Task::with("category")
            ->where("user_id", $user->id)->latest()->get();

        return response()->json([
            "data" => TaskResource::collection($tasks),
        ]);
    }

    public function show(Task $task): JsonResponse
    {
        $this->authorizeUser($task);

        $task->load("category");

        return response()->json([
            "data" => new TaskResource($task),
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if (!empty($data["category_id"])) {
            $data["category_id"] = $user->categories()
                ->findOrFail($data["category_id"])
                ->id;
        }

        $data["user_id"] = $user->id;

        $task = Task::create($data);

        return response()->json([
            "message" => __("tasks.created"),
            "data" => new TaskResource($task->load("category")),
        ], Status::HTTP_CREATED);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorizeUser($task);

        $data = $request->validated();
        $user = $request->user();

        if (array_key_exists("category_id", $data)) {
            if ($data["category_id"] === null) {
                $data["category_id"] = null;
            } else {
                $data["category_id"] = $user->categories()
                    ->findOrFail($data["category_id"])
                    ->id;
            }
        }

        $task->update($data);

        return response()->json([
            "message" => __("tasks.updated"),
            "data" => new TaskResource($task->load("category")),
        ]);
    }

    private function authorizeUser(Task $task): void
    {
        if ($task->user_id !== request()->user()->id) {
            abort(Status::HTTP_FORBIDDEN);
        }
    }
}
