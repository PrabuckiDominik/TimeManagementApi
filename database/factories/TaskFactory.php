<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(TaskStatus::cases());

        $dueDate = fake()->optional(0.8)->dateTimeBetween("-3 days", "+7 days");

        return [
            "name" => fake()->sentence(3),
            "description" => fake()->optional()->sentence(),
            "priority" => fake()->randomElement(TaskPriority::cases())->value,
            "status" => $status->value,
            "due_date" => $dueDate,
            "completed_at" => $status === TaskStatus::DONE
                ? fake()->dateTimeBetween("-3 days", "+3 days")
                : null,
        ];
    }
}
