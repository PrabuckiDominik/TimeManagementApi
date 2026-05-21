<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Tag;

class DeleteTagAction
{
    public function execute(Tag $tag): void
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($tag)
            ->event("deleted")
            ->withProperties([
                "tag_id" => $tag->id,
                "name" => $tag->name,
            ])
            ->log("Deleted tag");

        $tag->delete();
    }
}
