<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Illuminate\Support\Collection;
use TimeManagement\Models\Tag;
use TimeManagement\Models\User;

class GetUserTagsAction
{
    public function execute(User $user): Collection
    {
        return Tag::query()->where("user_id", $user->id)->latest()->get();
    }
}
