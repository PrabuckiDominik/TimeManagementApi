<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Category;

class DeleteCategoryAction
{
    public function execute(Category $category): void
    {
        $category->delete();
    }
}
