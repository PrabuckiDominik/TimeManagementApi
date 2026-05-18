<?php

declare(strict_types=1);

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;
use TimeManagement\Models\User;

class ActivityLogTest extends TestCase
{
    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()
            ->admin()
            ->create();

        $this->user = User::factory()
            ->create();
    }

    public function testAdministratorCanListActivityLogs(): void
    {
        activity()
            ->causedBy($this->admin)
            ->performedOn($this->user)
            ->event("updated")
            ->withProperties([
                "email" => $this->user->email,
            ])
            ->log("Updated managed user");

        Sanctum::actingAs($this->admin);

        $this->getJson("/api/admin/activity-logs")
            ->assertOk()
            ->assertJsonStructure([
                "data" => [
                    "*" => [
                        "id",
                        "log_name",
                        "description",
                        "event",
                        "subject_type",
                        "subject_id",
                        "causer_type",
                        "causer_id",
                        "causer",
                        "properties",
                        "created_at",
                    ],
                ],
                "meta" => [
                    "current_page",
                    "last_page",
                    "per_page",
                    "total",
                ],
            ])
            ->assertJsonFragment([
                "description" => "Updated managed user",
                "event" => "updated",
            ]);
    }

    public function testSuperAdministratorCanListActivityLogs(): void
    {
        $superAdmin = User::factory()
            ->superAdmin()
            ->create();

        activity()
            ->causedBy($superAdmin)
            ->performedOn($this->user)
            ->event("deleted")
            ->log("Deleted user");

        Sanctum::actingAs($superAdmin);

        $this->getJson("/api/admin/activity-logs")
            ->assertOk()
            ->assertJsonFragment([
                "description" => "Deleted user",
                "event" => "deleted",
            ]);
    }

    public function testRegularUserCannotListActivityLogs(): void
    {
        Sanctum::actingAs($this->user);

        $this->getJson("/api/admin/activity-logs")
            ->assertForbidden();
    }

    public function testAdministratorCanFilterActivityLogsByEvent(): void
    {
        activity()
            ->causedBy($this->admin)
            ->performedOn($this->user)
            ->event("created")
            ->log("Created tag");

        activity()
            ->causedBy($this->admin)
            ->performedOn($this->user)
            ->event("deleted")
            ->log("Deleted tag");

        Sanctum::actingAs($this->admin);

        $this->getJson("/api/admin/activity-logs?event=deleted")
            ->assertOk()
            ->assertJsonFragment([
                "description" => "Deleted tag",
                "event" => "deleted",
            ])
            ->assertJsonMissing([
                "description" => "Created tag",
                "event" => "created",
            ]);
    }

    public function testAdministratorCanFilterActivityLogsByCauser(): void
    {
        $otherUser = User::factory()
            ->create();

        activity()
            ->causedBy($this->admin)
            ->performedOn($this->user)
            ->event("updated")
            ->log("Admin activity");

        activity()
            ->causedBy($otherUser)
            ->performedOn($this->user)
            ->event("updated")
            ->log("Other user activity");

        Sanctum::actingAs($this->admin);

        $this->getJson("/api/admin/activity-logs?causer_id={$this->admin->id}")
            ->assertOk()
            ->assertJsonFragment([
                "description" => "Admin activity",
            ])
            ->assertJsonMissing([
                "description" => "Other user activity",
            ]);
    }

    public function testAdministratorCanPaginateActivityLogs(): void
    {
        Activity::query()->delete();

        foreach (range(1, 25) as $index) {
            activity()
                ->causedBy($this->admin)
                ->performedOn($this->user)
                ->event("created")
                ->log("Activity $index");
        }

        Sanctum::actingAs($this->admin);

        $this->getJson("/api/admin/activity-logs?per_page=10")
            ->assertOk()
            ->assertJsonPath("meta.per_page", 10)
            ->assertJsonPath("meta.current_page", 1)
            ->assertJsonPath("meta.total", 25);
    }
}
