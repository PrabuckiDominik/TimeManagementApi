<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Http\Requests\LoginRequest;
use TimeManagement\Http\Resources\UserProfileResource;

class LoginController extends Controller
{
    public function login(LoginRequest $loginRequest, AuthManager $auth): JsonResponse
    {
        $credentials = $loginRequest->validated();

        if (!$auth->attempt($credentials)) {
            return response()->json([
                "message" => __("auth.failed"),
            ], Status::HTTP_FORBIDDEN);
        }

        $user = $auth->user();

        if (!$user->hasVerifiedEmail()) {
            $auth->logout();

            return response()->json([
                "message" => __("auth.email_not_verified"),
            ], Status::HTTP_FORBIDDEN);
        }

        $token = $user->createToken("token")->plainTextToken;

        return response()->json([
            "message" => "success",
            "token" => $token,
            "user" => new UserProfileResource($user),
        ], Status::HTTP_OK);
    }
}
