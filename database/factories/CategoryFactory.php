<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TimeManagement\Models\Category;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => fake()->words(2, true),
            "color" => fake()->safeHexColor(),
        ];
    }
}
