<?php

declare(strict_types=1);

namespace TimeManagement\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;
use TimeManagement\Notifications\ResetPasswordNotification;
use TimeManagement\Notifications\VerifyEmailNotification;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection<int, Task> $tasks
 * @property-read Collection<int, Category> $categories
 * @property-read Collection<int, Tag> $tags
 */
class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        "name",
        "email",
        "password",
    ];
    protected $hidden = [
        "password",
        "remember_token",
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function overdueTasks(CarbonImmutable $now): HasMany
    {
        return $this->tasks()->overdue($now);
    }

    public function tasksByStatus(TaskStatus $status): HasMany
    {
        return $this->tasks()
            ->where("status", $status);
    }

    public function tasksByPriority(TaskPriority $priority): HasMany
    {
        return $this->tasks()
            ->where("priority", $priority);
    }

    public function totalTasksCount(): int
    {
        return $this->tasks()->count();
    }

    public function completedTasksCount(): int
    {
        return $this->completedTasks()->count();
    }

    public function todoTasksCount(): int
    {
        return $this->todoTasks()->count();
    }

    public function inProgressTasksCount(): int
    {
        return $this->inProgressTasks()->count();
    }

    public function overdueTasksCount(CarbonImmutable $now): int
    {
        return $this->overdueTasks($now)->count();
    }

    public function completedTasks(): HasMany
    {
        return $this->tasks()->done();
    }

    public function todoTasks(): HasMany
    {
        return $this->tasks()->todo();
    }

    public function inProgressTasks(): HasMany
    {
        return $this->tasks()->inProgress();
    }

    public function tasksByPriorityCount(TaskPriority $priority): int
    {
        return $this->tasksByPriority($priority)->count();
    }

    public function tasksByStatusCount(TaskStatus $status): int
    {
        return $this->tasksByStatus($status)->count();
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }
}
