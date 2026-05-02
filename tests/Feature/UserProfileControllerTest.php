<?php

declare(strict_types=1);

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response as Http;
use Tests\TestCase;
use TimeManagement\Models\User;

class UserProfileControllerTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testGuestCannotAccessProfile(): void
    {
        $this->getJson("/api/profile")
            ->assertStatus(Http::HTTP_UNAUTHORIZED);
    }

    public function testUserCanGetOwnProfile(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/profile");

        $response->assertStatus(Http::HTTP_OK)
            ->assertJson([
                "message" => __("profile.retrieved"),
                "data" => [
                    "id" => $this->user->id,
                    "name" => $this->user->name,
                    "email" => $this->user->email,
                ],
            ]);
    }

    public function testProfileDoesNotContainTasks(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/profile");

        $response->assertStatus(Http::HTTP_OK);

        $this->assertArrayNotHasKey("tasks", $response->json("data"));
    }

    public function testUserCanUpdateProfileName(): void
    {
        $response = $this->actingAs($this->user)
            ->putJson("/api/profile", [
                "name" => "New Name",
            ]);

        $response->assertStatus(Http::HTTP_OK)
            ->assertJson([
                "message" => __("profile.updated"),
                "data" => [
                    "name" => "New Name",
                ],
            ]);

        $this->assertDatabaseHas("users", [
            "id" => $this->user->id,
            "name" => "New Name",
        ]);
    }

    public function testUpdateProfileFailsWithInvalidData(): void
    {
        $response = $this->actingAs($this->user)
            ->putJson("/api/profile", [
                "name" => str_repeat("a", 300),
            ]);

        $response->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name"]);
    }
}
