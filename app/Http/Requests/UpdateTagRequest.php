<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeManagement\DTO\UpdateTagDto;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => ["sometimes", "string", "max:255"],
        ];
    }

    public function toDto(): UpdateTagDto
    {
        return new UpdateTagDto(
            name: $this->input("name"),
        );
    }
}
