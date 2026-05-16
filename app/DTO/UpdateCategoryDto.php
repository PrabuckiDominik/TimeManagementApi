<?php

declare(strict_types=1);

namespace TimeManagement\DTO;

class UpdateCategoryDto
{
    public function __construct(
        public ?string $title,
        public ?string $color,
        public bool $hasColor,
        public bool $hasTitle,
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->hasTitle) {
            $data["title"] = $this->title;
        }

        if ($this->hasColor) {
            $data["color"] = $this->color;
        }

        return $data;
    }
}
