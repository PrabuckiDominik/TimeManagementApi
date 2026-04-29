<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Models\User;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, int $id): JsonResponse
    {
        $user = User::query()->find($id);

        if (!$user) {
            return response()->json([
                "message" => __("auth.user_not_found"),
            ], Status::HTTP_NOT_FOUND);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                "message" => __("auth.email_already_verified"),
            ], Status::HTTP_OK);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json([
            "message" => __("auth.email_verified_successfully"),
        ], Status::HTTP_OK);
    }
}
