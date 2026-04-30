<?php

declare(strict_types=1);

namespace TimeManagement\Models;

use Carbon\Carbon;
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
}
