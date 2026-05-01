<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

class UpdateCategoryRequest
{
    public function rules(): array
    {
        return [
            "title" => ["sometimes", "string", "max:255"],
            "color" => ["nullable", "string", "max:20"],
        ];
    }
}
