<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeManagement\DTO\StoreCategoryDto;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:255"],
            "color" => ["nullable", "string", "max:20"],
        ];
    }

    public function toDto(): StoreCategoryDto
    {
        return new StoreCategoryDto(
            title: $this->input("title"),
            color: $this->input("color"),
        );
    }
}
