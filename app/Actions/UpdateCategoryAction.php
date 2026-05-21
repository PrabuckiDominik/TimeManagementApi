<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateCategoryDto;
use TimeManagement\Models\Category;

class UpdateCategoryAction
{
    public function execute(Category $category, UpdateCategoryDto $dto): Category
    {
        $old = $category->only([
            "title",
            "color",
        ]);

        $category->update($dto->toArray());

        $category->refresh();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->event("updated")
            ->withProperties([
                "old" => $old,
                "new" => $category->only([
                    "title",
                    "color",
                ]),
            ])
            ->log("Updated category");

        return $category;
    }
}
