<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\Models\Tag;

class ShowTagAction
{
    public function execute(Tag $tag): Tag
    {
        return $tag->load("tasks");
    }
}
