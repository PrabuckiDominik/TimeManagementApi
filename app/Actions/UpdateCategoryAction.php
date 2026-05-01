<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Category;
use TimeManagement\Models\User;

class UpdateCategoryAction
{
    public function execute(Category $category, array $data, User $user): Category
    {
        $category->update($data);

        return $category;
    }
}
