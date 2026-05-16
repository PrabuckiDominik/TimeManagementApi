<?php

declare(strict_types=1);

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response as Http;
use Tests\TestCase;
use TimeManagement\Models\Tag;
use TimeManagement\Models\User;

class TagControllerTest extends TestCase
{
    protected User $user;
    protected User $otherUser;
    protected Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        $this->tag = Tag::factory()->create([
            "user_id" => $this->user->id,
        ]);
    }

    public function testIndexReturnsOnlyUserTags(): void
    {
        Tag::factory()->count(3)->create(["user_id" => $this->user->id]);
        Tag::factory()->count(5)->create(["user_id" => $this->otherUser->id]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/tags");

        $response->assertStatus(Http::HTTP_OK);
        $this->assertCount(4, $response->json("data"));
    }

    public function testGuestCannotAccessTags(): void
    {
        $this->getJson("/api/tags")
            ->assertStatus(Http::HTTP_UNAUTHORIZED);
    }

    public function testShowReturnsOwnTag(): void
    {
        $this->actingAs($this->user)
            ->getJson("/api/tags/{$this->tag->id}")
            ->assertStatus(Http::HTTP_OK);
    }

    public function testUserCannotViewOtherUserTag(): void
    {
        $tag = Tag::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->getJson("/api/tags/$tag->id")
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }

    public function testStoreCreatesTag(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson("/api/tags", [
                "name" => "Important",
            ]);

        $response->assertStatus(Http::HTTP_CREATED);

        $this->assertDatabaseHas("tags", [
            "name" => "Important",
            "user_id" => $this->user->id,
        ]);
    }

    public function testStoreFailsWithInvalidData(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson("/api/tags", [
                "name" => "",
            ]);

        $response->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name"]);
    }

    public function testUpdateTag(): void
    {
        $response = $this->actingAs($this->user)
            ->putJson("/api/tags/{$this->tag->id}", [
                "name" => "Updated",
            ]);

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseHas("tags", [
            "id" => $this->tag->id,
            "name" => "Updated",
        ]);
    }

    public function testUserCannotUpdateOtherUserTag(): void
    {
        $tag = Tag::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/tags/$tag->id", [
                "name" => "Hack",
            ])
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }

    public function testUserCanDeleteOwnTag(): void
    {
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/tags/{$this->tag->id}");

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseMissing("tags", [
            "id" => $this->tag->id,
        ]);
    }

    public function testUserCannotDeleteOtherUserTag(): void
    {
        $tag = Tag::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->deleteJson("/api/tags/$tag->id")
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }
}
