<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Category;

class ShowCategoryAction
{
    public function execute(Category $category): Category
    {
        return $category->loadCount("tasks");
    }
}
