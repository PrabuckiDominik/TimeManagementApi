<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Category;

class DeleteCategoryAction
{
    public function execute(Category $category): void
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($category)
            ->event("deleted")
            ->withProperties([
                "category_id" => $category->id,
                "title" => $category->title,
                "color" => $category->color,
            ])
            ->log("Deleted category");

        $category->delete();
    }
}
