<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as Http;
use Tests\TestCase;
use TimeManagement\Models\Category;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class DashboardControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function testGuestCannotAccessDashboard(): void
    {
        $this->getJson("/api/dashboard")
            ->assertStatus(Http::HTTP_UNAUTHORIZED);
    }

    public function testDashboardReturnsUserStats(): void
    {
        Carbon::setTestNow("2026-05-05 12:00:00");

        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $category = Category::factory()->create([
            "user_id" => $user->id,
            "title" => "Work",
            "color" => "#123456",
        ]);
        Task::factory()
            ->done()
            ->create([
                "user_id" => $user->id,
                "category_id" => $category->id,
                "due_date" => "2026-05-05 10:00:00",
            ]);
        Task::factory()
            ->todo()
            ->overdue()
            ->create([
                "user_id" => $user->id,
                "category_id" => $category->id,
            ]);
        Task::factory()
            ->inProgress()
            ->create([
                "user_id" => $user->id,
                "category_id" => $category->id,
                "due_date" => "2026-05-15 09:00:00",
            ]);
        Task::factory()
            ->todo()
            ->create([
                "user_id" => $user->id,
                "category_id" => null,
                "due_date" => "2026-06-01 09:00:00",
            ]);
        $upcomingTask = Task::factory()
            ->todo()
            ->create([
                "user_id" => $user->id,
                "category_id" => $category->id,
                "name" => "Soon deadline",
                "due_date" => "2026-05-07 09:00:00",
            ]);
        Task::factory()
            ->todo()
            ->create([
                "user_id" => $user->id,
                "due_date" => "2026-05-20 09:00:00",
            ]);
        Task::factory()
            ->count(3)
            ->create([
                "user_id" => $otherUser->id,
            ]);

        $response = $this->actingAs($user)
            ->getJson("/api/dashboard");

        $response->assertStatus(Http::HTTP_OK);

        $data = $response->json("data");
        $this->assertSame(6, $data["task_stats"]["total_tasks"]);
        $this->assertSame(1, $data["task_stats"]["completed"]);
        $this->assertSame(1, $data["task_stats"]["in_progress"]);
        $this->assertSame(4, $data["task_stats"]["to_do"]);
        $this->assertCount(3, $data["priority_distribution"]);
        $this->assertCount(3, $data["status_distribution"]);
        $this->assertCount(2, $data["category_distribution"]);
        $this->assertEquals(
            "#123456",
            collect($data["category_distribution"])
                ->firstWhere("categoryId", $category->id)["color"],
        );

        $this->assertTrue(
            collect($data["category_distribution"])
                ->contains(fn($c) => $c["categoryId"] === null),
        );
        $this->assertCount(1, $data["upcoming_deadlines"]["tasks"]);

        $this->assertSame(
            $upcomingTask->id,
            $data["upcoming_deadlines"]["tasks"][0]["id"],
        );

        $this->assertSame(
            "Soon deadline",
            $data["upcoming_deadlines"]["tasks"][0]["name"],
        );
    }
}
