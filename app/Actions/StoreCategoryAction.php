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
        return Category::create([
            "user_id" => $user->id,
            "title" => $dto->title,
            "color" => $dto->color,
        ]);
    }
}
