<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Http\Requests\UpdateUserRequest;
use TimeManagement\Http\Resources\UserDetailResource;
use TimeManagement\Http\Resources\UserResource;
use TimeManagement\Models\User;

class UserProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->loadCount([
            "ownedEvents",
            "followers",
            "followingUsers",
        ])->load(["organizations", "ownedEvents", "badge"]);

        return response()->json([
            "message" => __("profile.retrieved"),
            "data" => new UserResource($user),
        ])->setStatusCode(Status::HTTP_OK);
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->update($request->validated());

        $user->loadCount([
            "ownedEvents",
            "followers",
            "followingUsers",
        ])->load([
            "organizations", "ownedEvents", "badge",
        ]);

        return response()->json([
            "message" => __("profile.updated"),
            "data" => new UserResource($user),
        ])->setStatusCode(Status::HTTP_OK);
    }

    public function showDetail(Request $request, User $user): JsonResponse
    {
        if ($request->user()->id === $user->id) {
            return response()->json([
                "message" => __("profile.redirected"),
                "redirect" => "/api/profile",
            ], 302);
        }

        $user->load(["ownedEvents", "badge"])->loadCount(["ownedEvents", "followers", "followingUsers"]);

        return response()->json([
            "message" => __("profile.retrieved"),
            "data" => new UserDetailResource($user),
        ])->setStatusCode(Status::HTTP_OK);
    }
}
