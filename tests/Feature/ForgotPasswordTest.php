<?php

declare(strict_types=1);

namespace Tests\Feature;

use Exception;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use TimeManagement\Models\User;
use TimeManagement\Notifications\ResetPasswordNotification;

class ForgotPasswordTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testUserCanRequestPasswordResetLink(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->postJson("/api/auth/forgot-password", [
            "email" => $user->email,
        ]);

        $response->assertOk()
            ->assertJson([
                "message" => trans("passwords.sent"),
            ]);

        Notification::assertSentTo(
            $user,
            ResetPasswordNotification::class,
        );
    }
}
