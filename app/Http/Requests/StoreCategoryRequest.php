<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

class StoreCategoryRequest
{
    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:255"],
            "color" => ["nullable", "string", "max:20"],
        ];
    }
}
