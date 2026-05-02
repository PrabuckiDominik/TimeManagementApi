<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use TimeManagement\Http\Controllers\CategoryController;
use TimeManagement\Http\Controllers\EmailVerificationController;
use TimeManagement\Http\Controllers\LoginController;
use TimeManagement\Http\Controllers\LogoutController;
use TimeManagement\Http\Controllers\RegisterController;
use TimeManagement\Http\Controllers\ResetPasswordController;
use TimeManagement\Http\Controllers\TagController;
use TimeManagement\Http\Controllers\TaskController;
use TimeManagement\Http\Controllers\UserProfileController;

Route::middleware("auth:sanctum")->group(function (): void {
    Route::get("/user", fn(Request $request): JsonResponse => $request->user());
    Route::post("/auth/logout", LogoutController::class);
    Route::apiResource("tasks", TaskController::class);
    Route::apiResource("categories", CategoryController::class);
    Route::apiResource("tags", TagController::class);
    Route::get("/profile", [UserProfileController::class, "show"]);
    Route::put("/profile", [UserProfileController::class, "update"]);
});

Route::get("/auth/verify-email/{id}/{hash}", [EmailVerificationController::class, "verify"])
    ->middleware("signed")
    ->name("verification.verify");

Route::post("/auth/login", [LoginController::class, "login"])->name("login");
Route::post("/auth/register", [RegisterController::class, "register"]);

Route::post("/auth/forgot-password", [ResetPasswordController::class, "sendResetLinkEmail"]);
Route::post("/auth/reset-password", [ResetPasswordController::class, "resetPassword"]);

Route::get("/reset-password/{token}", fn(string $token): JsonResponse => response()->json([
    "message" => "Temporary password reset.",
    "token" => $token,
]))->name("password.reset");
