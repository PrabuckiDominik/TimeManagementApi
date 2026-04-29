<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\ResetPasswordAction;
use TimeManagement\Actions\SendResetLinkAction;
use TimeManagement\Http\Requests\PasswordResetLinkRequest;
use TimeManagement\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function sendResetLinkEmail(PasswordResetLinkRequest $request, SendResetLinkAction $action): JsonResponse
    {
        $message = $action->execute($request->validated());

        return response()->json([
            "message" => $message,
        ], Status::HTTP_OK);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $action): JsonResponse
    {
        $status = $action->execute($request->only("email", "password", "password_confirmation", "token"));

        return $status === Password::PASSWORD_RESET
            ? response()->json(["message" => __("passwords.reset")], Status::HTTP_OK)
            : response()->json(["message" => __($status)], Status::HTTP_BAD_REQUEST);
    }
}
