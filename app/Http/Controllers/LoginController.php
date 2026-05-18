<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\ThrottleAction;
use TimeManagement\Http\Requests\LoginRequest;
use TimeManagement\Http\Resources\UserProfileResource;

class LoginController extends Controller
{
    public function login(
        LoginRequest $loginRequest,
        AuthManager $auth,
        ThrottleAction $throttle,
    ): JsonResponse {
        $credentials = $loginRequest->validated();

        $key = "login:" . $loginRequest->ip();

        $throttle->handleAttempts(
            key: $key,
            maxAttempts: 4,
            duration: "15min",
            translationKey: "auth.throttle_login",
        );

        if (!$auth->attempt($credentials)) {
            return response()->json([
                "message" => __("auth.failed"),
            ], Status::HTTP_FORBIDDEN);
        }

        RateLimiter::clear($key);

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
