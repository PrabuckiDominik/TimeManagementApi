<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\StoreTagDto;
use TimeManagement\Models\Tag;
use TimeManagement\Models\User;

class StoreTagAction
{
    public function execute(User $user, StoreTagDto $dto): Tag
    {
        return Tag::create([
            "user_id" => $user->id,
            "name" => $dto->name,
        ]);
    }
}
