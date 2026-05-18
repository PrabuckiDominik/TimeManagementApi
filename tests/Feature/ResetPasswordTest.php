<?php

declare(strict_types=1);

namespace Tests\Feature;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;
use TimeManagement\Models\User;
use TimeManagement\Notifications\ResetPasswordNotification;

class ResetPasswordTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testUserCanResetPasswordWithValidToken(): void
    {
        Notification::fake();

        $token = null;

        $user = User::factory()->create([
            "password" => Hash::make("old-password"),
        ]);

        $this->postJson("/api/auth/forgot-password", [
            "email" => $user->email,
        ]);

        Notification::assertSentTo(
            $user,
            ResetPasswordNotification::class,
            function (ResetPasswordNotification $notification) use (&$token): bool {
                $token = $notification->token;

                return true;
            },
        );

        $response = $this->postJson("/api/auth/reset-password", [
            "email" => $user->email,
            "token" => $token,
            "password" => "new-secure-password",
            "password_confirmation" => "new-secure-password",
        ]);

        $response->assertOk()
            ->assertJson([
                "message" => trans("passwords.reset"),
            ]);

        $this->assertTrue(
            Hash::check(
                "new-secure-password",
                $user->fresh()->password,
            ),
        );
    }

    public function testCannotResetWithInvalidToken(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson("/api/auth/reset-password", [
            "email" => $user->email,
            "token" => "fake-invalid-token",
            "password" => "something-new",
            "password_confirmation" => "something-new",
        ]);

        $response->assertStatus(400)
            ->assertJson([
                "message" => trans(Password::INVALID_TOKEN),
            ]);
    }
}
