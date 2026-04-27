<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TimeManagement\Models\Category;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class UserWithTaskDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            "email" => "user@example.com",
        ]);

        $categories = Category::factory()
            ->count(3)
            ->create([
                "user_id" => $user->id,
            ]);

        $categoryIds = $categories->pluck("id")->toArray();

        Task::factory()
            ->count(10)
            ->create([
                "user_id" => $user->id,
                "category_id" => fake()->optional()->randomElement($categoryIds),
            ]);
    }
}
