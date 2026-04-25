<?php

declare(strict_types=1);

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use TimeManagement\Models\User;

class LogoutUserTest extends TestCase
{
    public function testUserCanLogoutSuccessfully(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson("/api/auth/logout");

        $response->assertStatus(200)
            ->assertJson([
                "message" => __("auth.logout"),
            ]);
    }

    public function testGuestCannotLogout(): void
    {
        $response = $this->postJson("/api/auth/logout");
        $response->assertStatus(401);
    }
}
