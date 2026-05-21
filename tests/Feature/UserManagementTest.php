<?php

declare(strict_types=1);

namespace Tests\Feature;

use Exception;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use TimeManagement\Models\User;
use TimeManagement\Notifications\VerifyEmailNotification;

class UserManagementTest extends TestCase
{
    protected User $admin;
    protected User $superAdmin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()
            ->admin()
            ->create();

        $this->superAdmin = User::factory()
            ->superAdmin()
            ->create();

        $this->user = User::factory()
            ->create();
    }

    public function testAdministratorCanListUsers(): void
    {
        $this->actingAsAdmin();

        $this->getJson("/api/admin/users")
            ->assertOk()
            ->assertJsonFragment([
                "id" => $this->user->id,
                "email" => $this->user->email,
            ])
            ->assertJsonStructure([
                "data",
                "meta" => [
                    "current_page",
                    "last_page",
                    "per_page",
                    "total",
                ],
            ]);
    }

    public function testSuperAdministratorCanListUsers(): void
    {
        $this->actingAsSuperAdmin();

        $this->getJson("/api/admin/users")
            ->assertOk()
            ->assertJsonFragment([
                "id" => $this->user->id,
                "email" => $this->user->email,
            ])
            ->assertJsonStructure([
                "data",
                "meta" => [
                    "current_page",
                    "last_page",
                    "per_page",
                    "total",
                ],
            ]);
    }

    public function testRegularUserCannotListUsers(): void
    {
        $this->actingAsUser();

        $this->getJson("/api/admin/users")
            ->assertForbidden();
    }

    public function testAdministratorCanShowUser(): void
    {
        $this->actingAsAdmin();

        $this->getJson("/api/admin/users/{$this->user->id}")
            ->assertOk()
            ->assertJsonFragment([
                "id" => $this->user->id,
                "email" => $this->user->email,
            ]);
    }

    /**
     * @throws Exception
     */
    public function testAdministratorCanUpdateUser(): void
    {
        Notification::fake();

        $this->actingAsAdmin();

        $this->putJson("/api/admin/users/{$this->user->id}", [
            "name" => "Updated Name",
            "email" => "updated@example.com",
        ])
            ->assertOk()
            ->assertJsonFragment([
                "name" => "Updated Name",
                "email" => "updated@example.com",
            ]);

        $this->user->refresh();

        $this->assertSame(
            "Updated Name",
            $this->user->name,
        );

        $this->assertSame(
            "updated@example.com",
            $this->user->email,
        );

        $this->assertNull(
            $this->user->email_verified_at,
        );

        Notification::assertSentTo(
            $this->user,
            VerifyEmailNotification::class,
        );
    }

    public function testAdministratorCanDeleteUser(): void
    {
        $targetUser = User::factory()->create();

        $this->actingAsAdmin();

        $this->deleteJson("/api/admin/users/$targetUser->id")
            ->assertOk();

        $this->assertDatabaseMissing("users", [
            "id" => $targetUser->id,
        ]);
    }

    public function testAdministratorCannotDeleteSelf(): void
    {
        $this->actingAsAdmin();

        $this->deleteJson("/api/admin/users/{$this->admin->id}")
            ->assertForbidden();

        $this->assertDatabaseHas("users", [
            "id" => $this->admin->id,
        ]);
    }

    public function testAdministratorCannotUpdateSuperAdministrator(): void
    {
        $this->actingAsAdmin();

        $this->putJson("/api/admin/users/{$this->superAdmin->id}", [
            "name" => "Changed Name",
        ])->assertForbidden();
    }

    public function testAdministratorCannotDeleteSuperAdministrator(): void
    {
        $this->actingAsAdmin();

        $this->deleteJson("/api/admin/users/{$this->superAdmin->id}")
            ->assertForbidden();

        $this->assertDatabaseHas("users", [
            "id" => $this->superAdmin->id,
        ]);
    }

    public function testRegularUserCannotAccessAdminPanelRequests(): void
    {
        $targetUser = User::factory()->create();

        $this->actingAsUser();

        $this->getJson("/api/admin/users")
            ->assertForbidden();

        $this->getJson("/api/admin/users/$targetUser->id")
            ->assertForbidden();

        $this->putJson("/api/admin/users/$targetUser->id", [
            "name" => "Changed Name",
        ])->assertForbidden();

        $this->deleteJson("/api/admin/users/$targetUser->id")
            ->assertForbidden();
    }

    protected function actingAsAdmin(): void
    {
        Sanctum::actingAs($this->admin);
    }

    protected function actingAsSuperAdmin(): void
    {
        Sanctum::actingAs($this->superAdmin);
    }

    protected function actingAsUser(): void
    {
        Sanctum::actingAs($this->user);
    }
}
