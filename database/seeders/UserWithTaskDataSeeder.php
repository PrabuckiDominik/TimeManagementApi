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
            [
                "email" => "user@example.com",
            ],
            [
                "name" => "User",
                "password" => bcrypt("password"),
                "email_verified_at" => now(),
            ],
        );
        $user->assignRole(["user"]);

        $categories = Category::factory()
            ->count(5)
            ->create([
                "user_id" => $user->id,
            ]);

        $tags = Tag::factory()
            ->count(8)
            ->create([
                "user_id" => $user->id,
            ]);

        $tasks = collect([
            Task::factory()->todo()->count(5),
            Task::factory()->inProgress()->count(4),
            Task::factory()->done()->count(6),
            Task::factory()->overdue()->count(3),
            Task::factory()->highPriority()->count(2),
        ])
            ->flatMap(
                fn($factory) => $factory->make(),
            );

        foreach ($tasks as $task) {
            $task->user_id = $user->id;

            $task->category_id = $categories
                ->random()
                ->id;

            $task->save();

            $task->tags()->attach(
                $tags
                    ->random(rand(1, 3))
                    ->pluck("id"),
            );
        }
    }
}
