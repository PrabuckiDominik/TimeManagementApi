<?php

declare(strict_types=1);

namespace TimeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;

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
}
