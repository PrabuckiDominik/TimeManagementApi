<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateCategoryDto;
use TimeManagement\Models\Category;

class UpdateCategoryAction
{
    public function execute(Category $category, UpdateCategoryDto $dto): Category
    {
        $category->update($dto->toArray());

        return $category->refresh();
    }
}
