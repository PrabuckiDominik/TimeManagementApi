<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateCategoryDto;
use TimeManagement\Models\Category;

class UpdateCategoryAction
{
    public function execute(Category $category, UpdateCategoryDto $dto): Category
    {
        $data = array_filter([
            "title" => $dto->title,
            "color" => $dto->color,
        ], fn ($value) => $value !== null);

        $category->update($data);

        return $category->refresh();
    }
}
