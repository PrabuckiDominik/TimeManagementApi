<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\DeleteManagedUserAction;
use TimeManagement\Actions\GetManagedUsersAction;
use TimeManagement\Actions\UpdateManagedUserAction;
use TimeManagement\Http\Requests\UpdateManagedUserRequest;
use TimeManagement\Http\Resources\UserResource;
use TimeManagement\Models\User;

class UserManagementController extends Controller
{
    public function index(
        Request $request,
        GetManagedUsersAction $action,
    ): JsonResponse {
        $this->authorize("viewAny", User::class);

        $perPage = min(
            max((int)$request->query("per_page", 15), 1),
            100,
        );

        $users = $action->execute($perPage);

        return response()->json([
            "data" => UserResource::collection($users),
            "meta" => [
                "current_page" => $users->currentPage(),
                "last_page" => $users->lastPage(),
                "per_page" => $users->perPage(),
                "total" => $users->total(),
            ],
        ], Status::HTTP_OK);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize("view", $user);

        return response()->json([
            "data" => new UserResource($user),
        ], Status::HTTP_OK);
    }

    public function update(
        UpdateManagedUserRequest $request,
        User $user,
        UpdateManagedUserAction $action,
    ): JsonResponse {
        $this->authorize("update", $user);

        $user = $action->execute(
            user: $user,
            dto: $request->toDto(),
        );

        return response()->json([
            "message" => __("users.updated"),
            "data" => new UserResource($user),
        ], Status::HTTP_OK);
    }

    public function destroy(
        User $user,
        DeleteManagedUserAction $action,
    ): JsonResponse {
        $this->authorize("delete", $user);

        $action->execute($user);

        return response()->json([
            "message" => __("users.deleted_successfully"),
        ], Status::HTTP_OK);
    }
}
