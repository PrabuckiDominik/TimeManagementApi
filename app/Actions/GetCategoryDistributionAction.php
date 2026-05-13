<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\CategoryDistributionDto;
use TimeManagement\Models\User;

class GetCategoryDistributionAction
{
    /**
     * @return array<CategoryDistributionDto>
     */
    public function execute(User $user): array
    {
        $categories = $user->categories()
            ->whereHas("tasks")
            ->withCount("tasks")
            ->orderBy("title")
            ->get()
            ->map(
                fn($category): CategoryDistributionDto => new CategoryDistributionDto(
                    categoryId: $category->id,
                    title: $category->title,
                    color: $category->color,
                    count: $category->tasks_count,
                ),
            );

        $uncategorized = $user->tasks()
            ->whereNull("category_id")
            ->count();

        if ($uncategorized > 0) {
            $categories->push(
                new CategoryDistributionDto(
                    categoryId: null,
                    title: null,
                    color: null,
                    count: $uncategorized,
                ),
            );
        }

        return $categories
            ->values()
            ->all();
    }
}
