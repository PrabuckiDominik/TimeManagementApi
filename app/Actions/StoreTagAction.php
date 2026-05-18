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
        $tag = Tag::create([
            "user_id" => $user->id,
            "name" => $dto->name,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($tag)
            ->event("created")
            ->withProperties([
                "tag_id" => $tag->id,
                "name" => $tag->name,
            ])
            ->log("Created tag");

        return $tag;
    }
}
