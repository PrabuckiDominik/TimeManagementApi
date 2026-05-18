<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use RateLimiter;
use Tests\TestCase;
use TimeManagement\Models\User;

class LoginUserTest extends TestCase
{
    public function testUserCanLoginSuccessfully(): void
    {
        $password = "securePassword123";

        User::factory()->create([
            "email" => "jan.kowalski@gmail.com",
            "password" => Hash::make($password),
        ]);

        $response = $this->postJson("/api/auth/login", $this->validData());

        $response->assertStatus(200)
            ->assertJsonStructure([
                "message",
                "token",
                "user",
            ])
            ->assertJson([
                "message" => "success",
            ]);
    }

    public function testUserCannotLoginWithWrongCredentials(): void
    {
        User::factory()->create([
            "email" => "jan.kowalski@gmail.com",
            "password" => Hash::make("correctPassword"),
        ]);

        $response = $this->postJson("/api/auth/login", $this->validData(["password" => "wrongPassword"]));

        $response->assertStatus(403)
            ->assertJson([
                "message" => __("auth.failed"),
            ]);
    }

    public function testUserCannotLoginWithInvalidData(): void
    {
        $response = $this->postJson("/api/auth/login", [
            "email" => "not-an-email",
            "password" => "",
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["email", "password"]);
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            "email" => "jan.kowalski@gmail.com",
            "password" => "securePassword123",
        ], $overrides);
    }

    public function testUserIsThrottledAfterTooManyFailedLoginAttempts(): void
    {
        RateLimiter::clear("login:127.0.0.1");

        User::factory()->create([
            "email" => "jan.kowalski@gmail.com",
            "password" => Hash::make("correctPassword"),
        ]);

        foreach (range(1, 4) as $attempt) {
            $this->postJson("/api/auth/login", $this->validData([
                "password" => "wrongPassword",
            ]))->assertStatus(403);
        }

        $this->postJson("/api/auth/login", $this->validData([
            "password" => "wrongPassword",
        ]))
            ->assertStatus(429)
            ->assertJson([
                "message" => __("auth.throttle_login"),
            ]);
    }
}
