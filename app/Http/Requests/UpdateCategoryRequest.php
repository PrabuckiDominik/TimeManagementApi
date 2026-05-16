<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use TimeManagement\DTO\UpdateCategoryDto;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title" => [
                "sometimes",
                "string",
                "max:255",
                Rule::unique("categories", "title")
                    ->ignore($this->route("category")->id)
                    ->where(fn($query) => $query->where("user_id", $this->user()->id)),
            ],
            "color" => ["nullable", "string", "max:20"],
        ];
    }

    public function toDto(): UpdateCategoryDto
    {
        return new UpdateCategoryDto(
            title: $this->input("title"),
            color: $this->input("color"),
            hasColor: $this->has("color"),
            hasTitle: $this->has("title"),
        );
    }
}
