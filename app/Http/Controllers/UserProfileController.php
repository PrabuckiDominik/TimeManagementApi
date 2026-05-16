<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\UpdateUserAction;
use TimeManagement\Http\Requests\UpdateUserRequest;
use TimeManagement\Http\Resources\UserProfileResource;

class UserProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $request->user();

        return response()->json([
            "message" => __("profile.retrieved"),
            "data" => new UserProfileResource($request->user()),
        ])->setStatusCode(Status::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, UpdateUserAction $action): JsonResponse
    {
        $user = $action->execute($request->user(), $request->toDto());

        return response()->json([
            "message" => __("profile.updated"),
            "data" => new UserProfileResource($user),
        ])->setStatusCode(Status::HTTP_OK);
    }
}
