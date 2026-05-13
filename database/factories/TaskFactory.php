<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Enums\TaskStatus;
use TimeManagement\Models\Task;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(TaskStatus::cases());

        return [
            "name" => fake()->sentence(3),
            "description" => fake()->optional()->sentence(),

            "priority" => fake()
                ->randomElement(TaskPriority::cases())
                ->value,

            "status" => $status->value,

            "due_date" => fake()
                ->optional(0.9)
                ->dateTimeBetween("-5 days", "+14 days"),

            "completed_at" => $status === TaskStatus::DONE
                ? fake()->dateTimeBetween("-5 days")
                : null,
        ];
    }

    public function todo(): static
    {
        return $this->state([
            "status" => TaskStatus::TODO,
            "completed_at" => null,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state([
            "status" => TaskStatus::IN_PROGRESS,
            "completed_at" => null,
        ]);
    }

    public function done(): static
    {
        return $this->state([
            "status" => TaskStatus::DONE,
            "completed_at" => now(),
        ]);
    }

    public function overdue(): static
    {
        return $this->state([
            "due_date" => now()->subDays(2),
            "status" => TaskStatus::TODO,
        ]);
    }

    public function highPriority(): static
    {
        return $this->state([
            "priority" => TaskPriority::HIGH,
        ]);
    }
}
