<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TimeManagement\Models\Category;
use TimeManagement\Models\Tag;
use TimeManagement\Models\Task;
use TimeManagement\Models\User;

class UserWithTaskDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ["email" => "user@example.com"],
            [
                "name" => "User",
                "password" => bcrypt("password"),
                "email_verified_at" => now(),
            ],
        );

        $categories = Category::factory()
            ->count(3)
            ->create([
                "user_id" => $user->id,
            ]);

        $categoryIds = $categories->pluck("id")->toArray();

        $tags = Tag::factory()
            ->count(5)
            ->create([
                "user_id" => $user->id,
            ]);

        $tasks = Task::factory()
            ->count(10)
            ->create([
                "user_id" => $user->id,
                "category_id" => fake()->optional()->randomElement($categoryIds),
            ]);

        foreach ($tasks as $task) {
            $randomTags = $tags->shuffle()->take(rand(0, 3));

            $task->tags()->attach($randomTags->pluck("id"));
        }
    }
}
