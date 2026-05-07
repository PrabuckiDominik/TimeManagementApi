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

        $tagNames = [
            "work",
            "personal",
            "urgent",
            "meeting",
            "study",
        ];

        $tags = collect($tagNames)->map(
            fn(string $name): Tag => Tag::firstOrCreate(
                [
                    "user_id" => $user->id,
                    "name" => $name,
                ],
            ),
        );

        $tasks = Task::factory()
            ->count(10)
            ->create([
                "user_id" => $user->id,
                "category_id" => fake()->optional()->randomElement($categoryIds),
            ]);

        foreach ($tasks as $task) {
            $randomTags = $tags->shuffle()->take(rand(0, 3));

            $task->tags()->syncWithoutDetaching(
                $randomTags->pluck("id"),
            );
        }
    }
}
