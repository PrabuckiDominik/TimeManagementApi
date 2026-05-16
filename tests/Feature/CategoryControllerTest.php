<?php

declare(strict_types=1);

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response as Http;
use Tests\TestCase;
use TimeManagement\Models\Category;
use TimeManagement\Models\User;

class CategoryControllerTest extends TestCase
{
    protected User $user;
    protected User $otherUser;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        $this->category = Category::factory()->create([
            "user_id" => $this->user->id,
        ]);
    }

    public function testIndexReturnsOnlyUserCategories(): void
    {
        Category::factory()->count(3)->create([
            "user_id" => $this->user->id,
        ]);

        Category::factory()->count(5)->create([
            "user_id" => $this->otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/categories");

        $response->assertStatus(Http::HTTP_OK);
        $this->assertCount(4, $response->json("data"));
    }

    public function testGuestCannotAccessCategories(): void
    {
        $this->getJson("/api/categories")
            ->assertStatus(Http::HTTP_UNAUTHORIZED);
    }

    public function testShowReturnsOwnCategory(): void
    {
        $this->actingAs($this->user)
            ->getJson("/api/categories/{$this->category->id}")
            ->assertStatus(Http::HTTP_OK);
    }

    public function testUserCannotViewOtherUserCategory(): void
    {
        $category = Category::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->getJson("/api/categories/$category->id")
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }

    public function testStoreCreatesCategory(): void
    {
        $payload = [
            "title" => "Work",
            "color" => "#FF0000",
        ];

        $response = $this->actingAs($this->user)
            ->postJson("/api/categories", $payload);

        $response->assertStatus(Http::HTTP_CREATED)
            ->assertJson([
                "message" => __("categories.created"),
            ]);

        $this->assertDatabaseHas("categories", [
            "title" => "Work",
            "user_id" => $this->user->id,
        ]);
    }

    public function testStoreFailsWithInvalidData(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson("/api/categories", [
                "title" => "",
            ]);

        $response->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["title"]);
    }

    public function testUpdateCategory(): void
    {
        $payload = [
            "title" => "Updated Category",
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/categories/{$this->category->id}", $payload);

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseHas("categories", [
            "id" => $this->category->id,
            "title" => "Updated Category",
        ]);
    }

    public function testUserCannotUpdateOtherUserCategory(): void
    {
        $category = Category::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/categories/$category->id", [
                "title" => "Hack",
            ])
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }

    public function testUpdateCanSetColorToNull(): void
    {
        $response = $this->actingAs($this->user)
            ->putJson("/api/categories/{$this->category->id}", [
                "color" => null,
            ]);

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseHas("categories", [
            "id" => $this->category->id,
            "color" => null,
        ]);
    }

    public function testUpdateFailsWithInvalidData(): void
    {
        $response = $this->actingAs($this->user)
            ->putJson("/api/categories/{$this->category->id}", [
                "title" => "",
            ]);

        $response->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["title"]);
    }

    public function testUserCanDeleteOwnCategory(): void
    {
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/categories/{$this->category->id}");

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseMissing("categories", [
            "id" => $this->category->id,
        ]);
    }

    public function testUserCannotDeleteOtherUserCategory(): void
    {
        $category = Category::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->deleteJson("/api/categories/$category->id")
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }

    public function testUserCannotCreateDuplicateCategoryTitle(): void
    {
        Category::factory()->create([
            "user_id" => $this->user->id,
            "title" => "Work",
        ]);

        $response = $this->actingAs($this->user)
            ->postJson("/api/categories", [
                "title" => "Work",
            ]);

        $response->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY);
    }
}
