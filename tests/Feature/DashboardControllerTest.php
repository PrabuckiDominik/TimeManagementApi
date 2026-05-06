<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response as Http;
use Tests\TestCase;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;
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

    public function testDashboardReturnsUserTaskStats(): void
    {
        Carbon::setTestNow("2026-05-05 12:00:00");

        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $category = Category::factory()->create([
            "user_id" => $user->id,
            "title" => "Work",
            "color" => "#123456",
        ]);

        Task::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id,
            "priority" => TaskPriority::HIGH->value,
            "status" => TaskStatus::DONE->value,
            "due_date" => "2026-05-05 10:00:00",
            "completed_at" => "2026-05-05 11:00:00",
            "created_at" => "2026-05-05 09:00:00",
            "updated_at" => "2026-05-05 11:00:00",
        ]);

        Task::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id,
            "priority" => TaskPriority::LOW->value,
            "status" => TaskStatus::TODO->value,
            "due_date" => "2026-05-04 09:00:00",
            "completed_at" => null,
            "created_at" => "2026-05-02 09:00:00",
            "updated_at" => "2026-05-02 09:00:00",
        ]);

        Task::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id,
            "priority" => TaskPriority::MEDIUM->value,
            "status" => TaskStatus::IN_PROGRESS->value,
            "due_date" => "2026-05-15 09:00:00",
            "completed_at" => null,
            "created_at" => "2026-04-30 09:00:00",
            "updated_at" => "2026-04-30 09:00:00",
        ]);

        Task::factory()->create([
            "user_id" => $user->id,
            "category_id" => null,
            "priority" => TaskPriority::LOW->value,
            "status" => TaskStatus::TODO->value,
            "due_date" => "2026-06-01 09:00:00",
            "completed_at" => null,
            "created_at" => "2026-05-03 09:00:00",
            "updated_at" => "2026-05-03 09:00:00",
        ]);

        $upcomingTask = Task::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id,
            "name" => "Soon deadline",
            "priority" => TaskPriority::MEDIUM->value,
            "status" => TaskStatus::TODO->value,
            "due_date" => "2026-05-07 09:00:00",
            "completed_at" => null,
            "created_at" => "2026-05-05 09:00:00",
            "updated_at" => "2026-05-05 09:00:00",
        ]);

        Task::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id,
            "name" => "Done deadline",
            "priority" => TaskPriority::MEDIUM->value,
            "status" => TaskStatus::DONE->value,
            "due_date" => "2026-05-08 09:00:00",
            "completed_at" => "2026-05-05 11:00:00",
            "created_at" => "2026-05-05 09:00:00",
            "updated_at" => "2026-05-05 11:00:00",
        ]);

        Task::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id,
            "name" => "Outside deadline window",
            "priority" => TaskPriority::MEDIUM->value,
            "status" => TaskStatus::TODO->value,
            "due_date" => "2026-05-13 00:00:00",
            "completed_at" => null,
            "created_at" => "2026-05-05 09:00:00",
            "updated_at" => "2026-05-05 09:00:00",
        ]);

        Task::factory()->count(3)->create([
            "user_id" => $otherUser->id,
            "status" => TaskStatus::DONE->value,
        ]);

        $response = $this->actingAs($user)
            ->getJson("/api/dashboard");

        $response->assertStatus(Http::HTTP_OK)
            ->assertJson([
                "data" => [
                    "total_tasks" => 7,
                    "completed" => 2,
                    "in_progress" => 1,
                    "to_do" => 4,
                    "overdue" => 1,
                    "priority_distribution" => [
                        [
                            "priority" => TaskPriority::LOW->value,
                            "count" => 2,
                        ],
                        [
                            "priority" => TaskPriority::MEDIUM->value,
                            "count" => 4,
                        ],
                        [
                            "priority" => TaskPriority::HIGH->value,
                            "count" => 1,
                        ],
                    ],
                    "status_distribution" => [
                        [
                            "status" => TaskStatus::TODO->value,
                            "count" => 4,
                        ],
                        [
                            "status" => TaskStatus::IN_PROGRESS->value,
                            "count" => 1,
                        ],
                        [
                            "status" => TaskStatus::DONE->value,
                            "count" => 2,
                        ],
                    ],
                    "weekly" => [
                        "period_start" => "2026-05-04",
                        "period_end" => "2026-05-10",
                        "created_tasks" => 4,
                        "completed" => 2,
                        "due_tasks" => 4,
                        "to_do" => 2,
                        "in_progress" => 0,
                        "overdue" => 1,
                    ],
                    "monthly" => [
                        "period_start" => "2026-05-01",
                        "period_end" => "2026-05-31",
                        "created_tasks" => 6,
                        "completed" => 2,
                        "due_tasks" => 6,
                        "to_do" => 3,
                        "in_progress" => 1,
                        "overdue" => 1,
                    ],
                    "upcoming_deadlines" => [
                        "period_start" => "2026-05-05",
                        "period_end" => "2026-05-12",
                        "tasks" => [
                            [
                                "name" => "Soon deadline",
                                "is_overdue" => false,
                                "category" => [
                                    "id" => $category->id,
                                    "title" => "Work",
                                    "color" => "#123456",
                                ],
                            ],
                        ],
                    ],
                ],
            ])
            ->assertJsonFragment([
                "category_id" => $category->id,
                "title" => "Work",
                "color" => "#123456",
                "count" => 6,
            ])
            ->assertJsonFragment([
                "category_id" => null,
                "title" => null,
                "color" => null,
                "count" => 1,
            ]);

        $this->assertCount(1, $response->json("data.upcoming_deadlines.tasks"));
        $this->assertSame($upcomingTask->id, $response->json("data.upcoming_deadlines.tasks.0.id"));
    }
}
