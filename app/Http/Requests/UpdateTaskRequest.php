<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeManagement\DTO\UpdateTaskDto;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["sometimes", "string", "max:255"],
            "description" => ["nullable", "string"],
            "priority" => ["nullable", "in:" . implode(",", array_column(TaskPriority::cases(), "value"))],
            "status" => ["nullable", "in:" . implode(",", array_column(TaskStatus::cases(), "value"))],
            "due_date" => ["nullable", "date"],
            "category_id" => ["nullable", "integer"],
            "tag_ids" => ["sometimes", "array"],
            "tag_ids.*" => ["integer"],
        ];
    }

    public function toDto(): UpdateTaskDto
    {
        $categoryId = $this->input("category_id");

        return new UpdateTaskDto(
            name: $this->input("name"),
            description: $this->input("description"),
            priority: $this->input("priority")
                ? TaskPriority::from($this->input("priority"))
                : null,
            status: $this->input("status")
                ? TaskStatus::from($this->input("status"))
                : null,
            due_date: $this->input("due_date"),
            hasCategoryId: $this->exists("category_id"),
            category_id: $categoryId !== null
                ? (int)$categoryId
                : null,
            tag_ids: $this->input("tag_ids"),
            hasTagIds: $this->exists("tag_ids"),
        );
    }
}
