<?php

declare(strict_types=1);

namespace TimeManagement\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property ?string $description
 * @property ?TaskStatus $status
 * @property ?TaskPriority $priority
 * @property bool $is_overdue
 * @property ?Carbon $due_date
 * @property ?Carbon $completed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder done()
 * @method static Builder todo()
 * @method static Builder inProgress()
 * @method static Builder overdue(CarbonImmutable $now)
 * @method static Builder betweenDates(string $column, CarbonImmutable $start, CarbonImmutable $end)
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "category_id",
        "name",
        "description",
        "priority",
        "status",
        "due_date",
        "completed_at",
    ];
    protected $casts = [
        "priority" => TaskPriority::class,
        "status" => TaskStatus::class,
        "due_date" => "datetime",
        "completed_at" => "datetime",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isOverdue(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== TaskStatus::DONE;
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeDone(Builder $query): Builder
    {
        return $query->where("status", TaskStatus::DONE);
    }

    public function scopeTodo(Builder $query): Builder
    {
        return $query->where("status", TaskStatus::TODO);
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where("status", TaskStatus::IN_PROGRESS);
    }

    public function scopeOverdue(
        Builder $query,
        CarbonImmutable $now,
    ): Builder {
        return $query
            ->whereNotNull("due_date")
            ->where("due_date", "<", $now)
            ->where("status", "!=", TaskStatus::DONE);
    }

    public function scopeBetweenDates(
        Builder $query,
        string $column,
        CarbonImmutable $start,
        CarbonImmutable $end,
    ): Builder {
        return $query->whereBetween($column, [$start, $end]);
    }
}
