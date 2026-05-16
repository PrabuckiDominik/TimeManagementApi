<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            "title" => [
                "required",
                "string",
                "max:255",
                Rule::unique("categories", "title")
                    ->where(fn($query) => $query->where("user_id", $this->user()->id)),
            ],
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
