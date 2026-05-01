<?php

declare(strict_types=1);

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response as Http;
use Tests\TestCase;
use TimeManagement\Models\Category;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class TaskControllerTest extends TestCase
{
    protected User $user;
    protected User $otherUser;
    protected Task $task;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        $this->category = Category::factory()->create([
            "user_id" => $this->user->id,
        ]);

        $this->task = Task::factory()->create([
            "user_id" => $this->user->id,
            "category_id" => $this->category->id,
        ]);
    }

    public function testIndexReturnsOnlyUserTasks(): void
    {
        Task::factory()->count(3)->create([
            "user_id" => $this->user->id,
        ]);

        Task::factory()->count(5)->create([
            "user_id" => $this->otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/tasks");

        $response->assertStatus(Http::HTTP_OK);
        $this->assertCount(4, $response->json("data"));
    }

    public function testGuestCannotAccessTasks(): void
    {
        $this->getJson("/api/tasks")
            ->assertStatus(Http::HTTP_UNAUTHORIZED);
    }

    public function testShowReturnsOwnTask(): void
    {
        $this->actingAs($this->user)
            ->getJson("/api/tasks/{$this->task->id}")
            ->assertStatus(Http::HTTP_OK);
    }

    public function testUserCannotViewOtherUserTask(): void
    {
        $task = Task::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->getJson("/api/tasks/$task->id")
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }

    public function testStoreCreatesTask(): void
    {
        $payload = [
            "name" => "New task",
            "description" => "Test desc",
            "category_id" => $this->category->id,
        ];

        $response = $this->actingAs($this->user)
            ->postJson("/api/tasks", $payload);

        $response->assertStatus(Http::HTTP_CREATED)
            ->assertJson([
                "message" => __("tasks.created"),
            ]);

        $this->assertDatabaseHas("tasks", [
            "name" => "New task",
            "user_id" => $this->user->id,
        ]);
    }

    public function testStoreFailsWithInvalidData(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson("/api/tasks", [
                "name" => "",
            ]);

        $response->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name"]);
    }

    public function testUserCannotAssignOtherUserCategory(): void
    {
        $foreignCategory = Category::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->postJson("/api/tasks", [
                "name" => "Task",
                "category_id" => $foreignCategory->id,
            ]);

        $response->assertStatus(Http::HTTP_NOT_FOUND);
    }

    public function testUpdateTask(): void
    {
        $payload = [
            "name" => "Updated name",
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/tasks/{$this->task->id}", $payload);

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseHas("tasks", [
            "id" => $this->task->id,
            "name" => "Updated name",
        ]);
    }

    public function testUserCannotUpdateOtherUserTask(): void
    {
        $task = Task::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->putJson("/api/tasks/$task->id", [
                "name" => "New Task Name",
            ])
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }

    public function testUpdateCanRemoveCategory(): void
    {
        $response = $this->actingAs($this->user)
            ->putJson("/api/tasks/{$this->task->id}", [
                "category_id" => null,
            ]);

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseHas("tasks", [
            "id" => $this->task->id,
            "category_id" => null,
        ]);
    }

    public function testUpdateFailsWithInvalidData(): void
    {
        $response = $this->actingAs($this->user)
            ->putJson("/api/tasks/{$this->task->id}", [
                "name" => "",
            ]);

        $response->assertStatus(Http::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name"]);
    }

    public function testUserCanDeleteOwnTask(): void
    {
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/tasks/{$this->task->id}");

        $response->assertStatus(Http::HTTP_OK);

        $this->assertDatabaseMissing("tasks", [
            "id" => $this->task->id,
        ]);
    }

    public function testUserCannotDeleteOtherUserTask(): void
    {
        $task = Task::factory()->create([
            "user_id" => $this->otherUser->id,
        ]);

        $this->actingAs($this->user)
            ->deleteJson("/api/tasks/{$task->id}")
            ->assertStatus(Http::HTTP_FORBIDDEN);
    }
}
