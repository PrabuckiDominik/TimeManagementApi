<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use TimeManagement\DTO\UpdateTagDto;
use TimeManagement\Models\Tag;

class UpdateTagAction
{
    public function execute(Tag $tag, UpdateTagDto $dto): Tag
    {
        $tag->update($dto->toArray());

        return $tag->refresh();
    }
}
