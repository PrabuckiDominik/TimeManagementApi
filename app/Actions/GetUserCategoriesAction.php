<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Illuminate\Support\Collection;
use TimeManagement\Models\Category;
use TimeManagement\Models\User;

class GetUserCategoriesAction
{
    public function execute(User $user): Collection
    {
        return Category::query()->where("user_id", $user->id)->withCount("tasks")->latest()->get();
    }
}
