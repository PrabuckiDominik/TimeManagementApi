<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeManagement\DTO\UpdateUserDto;

class UpdateUserRequest extends FormRequest
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

    public function toDto(): UpdateUserDto
    {
        return new UpdateUserDto(
            name: $this->input("name"),
        );
    }
}
