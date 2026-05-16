<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as Http;
use Tests\TestCase;
use TimeManagement\Models\User;

class UpdatePasswordControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function testGuestCannotChangePassword(): void
    {
        $this->putJson("/api/auth/change-password", [
            "current_password" => "password",
            "new_password" => "new-password",
            "new_password_confirmation" => "new-password",
        ])->assertStatus(Http::HTTP_UNAUTHORIZED);
    }

    public function testUserCanChangePassword(): void
    {
        $user = User::factory()->create([
            "password" => Hash::make("password"),
        ]);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/auth/change-password", [
                "current_password" => "password",
                "new_password" => "new-password",
                "new_password_confirmation" => "new-password",
            ]);

        $response
            ->assertStatus(Http::HTTP_OK)
            ->assertJson([
                "message" => __("passwords.updated_successfully"),
            ]);

        $this->assertTrue(
            Hash::check(
                "new-password",
                $user->refresh()->password,
            ),
        );
    }

    public function testUserCannotChangePasswordWithWrongCurrentPassword(): void
    {
        $user = User::factory()->create([
            "password" => Hash::make("password"),
        ]);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/auth/change-password", [
                "current_password" => "wrong-password",
                "new_password" => "new-password",
                "new_password_confirmation" => "new-password",
            ]);

        $response
            ->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                "current_password",
            ]);

        $this->assertTrue(
            Hash::check(
                "password",
                $user->refresh()->password,
            ),
        );
    }

    public function testUserCannotUseCurrentPasswordAsNewPassword(): void
    {
        $user = User::factory()->create([
            "password" => Hash::make("password"),
        ]);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/auth/change-password", [
                "current_password" => "password",
                "new_password" => "password",
                "new_password_confirmation" => "password",
            ]);

        $response
            ->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                "message" => __("passwords.same_as_current"),
            ]);

        $this->assertTrue(
            Hash::check(
                "password",
                $user->refresh()->password,
            ),
        );
    }

    public function testNewPasswordMustBeConfirmed(): void
    {
        $user = User::factory()->create([
            "password" => Hash::make("password"),
        ]);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/auth/change-password", [
                "current_password" => "password",
                "new_password" => "new-password",
                "new_password_confirmation" => "different-password",
            ]);

        $response
            ->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                "new_password",
            ]);
    }

    public function testNewPasswordMustHaveAtLeastEightCharacters(): void
    {
        $user = User::factory()->create([
            "password" => Hash::make("password"),
        ]);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/auth/change-password", [
                "current_password" => "password",
                "new_password" => "short",
                "new_password_confirmation" => "short",
            ]);

        $response
            ->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                "new_password",
            ]);
    }

    public function testPasswordChangeIsThrottled(): void
    {
        $user = User::factory()->create([
            "password" => Hash::make("password"),
        ]);

        $this
            ->actingAs($user)
            ->putJson("/api/auth/change-password", [
                "current_password" => "password",
                "new_password" => "new-password",
                "new_password_confirmation" => "new-password",
            ])
            ->assertStatus(Http::HTTP_OK);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/auth/change-password", [
                "current_password" => "new-password",
                "new_password" => "another-password",
                "new_password_confirmation" => "another-password",
            ]);

        $response
            ->assertStatus(Http::HTTP_TOO_MANY_REQUESTS)
            ->assertJson([
                "message" => __("passwords.throttled"),
            ]);
    }
}
