<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\StoreCategoryDto;
use TimeManagement\Models\Category;
use TimeManagement\Models\User;

class StoreCategoryAction
{
    public function execute(User $user, StoreCategoryDto $dto): Category
    {
        $category = Category::create([
            "user_id" => $user->id,
            "title" => $dto->title,
            "color" => $dto->color,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($category)
            ->event("created")
            ->withProperties([
                "category_id" => $category->id,
                "title" => $category->title,
                "color" => $category->color,
            ])
            ->log("Created category");

        return $category;
    }
}
