<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\RegisterUserAction;
use TimeManagement\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $registerRequest, RegisterUserAction $action): JsonResponse
    {
        $action->execute($registerRequest->toDto());

        return response()->json([
            "message" => "success",
        ])->setStatusCode(Status::HTTP_OK);
    }
}
