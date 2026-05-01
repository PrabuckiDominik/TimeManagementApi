<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Category;
use TimeManagement\Models\User;

class StoreCategoryAction
{
    public function execute(User $user, array $data): Category
    {
        $data["user_id"] = $user->id;

        return Category::create($data);
    }
}
