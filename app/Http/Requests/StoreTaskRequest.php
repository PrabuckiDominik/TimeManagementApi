<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
            "description" => ["nullable", "string"],
            "priority" => ["nullable", "in:" . implode(",", array_column(TaskPriority::cases(), "value"))],
            "status" => ["nullable", "in:" . implode(",", array_column(TaskStatus::cases(), "value"))],
            "due_date" => ["nullable", "date"],
            "category_id" => ["nullable", "integer"],
        ];
    }
}
