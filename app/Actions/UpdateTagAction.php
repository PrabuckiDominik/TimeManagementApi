<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateTagDto;
use TimeManagement\Models\Tag;

class UpdateTagAction
{
    public function execute(Tag $tag, UpdateTagDto $dto): Tag
    {
        $old = $tag->only([
            "name",
        ]);

        $tag->update($dto->toArray());

        $tag->refresh();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($tag)
            ->event("updated")
            ->withProperties([
                "old" => $old,
                "new" => $tag->only([
                    "name",
                ]),
            ])
            ->log("Updated tag");

        return $tag;
    }
}
