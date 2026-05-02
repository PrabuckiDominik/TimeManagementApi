<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Tag;

class DeleteTagAction
{
    public function execute(Tag $tag): void
    {
        $tag->delete();
    }
}
