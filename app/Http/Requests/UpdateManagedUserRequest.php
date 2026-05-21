<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use TimeManagement\DTO\UpdateManagedUserDto;

class UpdateManagedUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["sometimes", "string", "max:255"],
            "email" => [
                "sometimes",
                "email",
                "max:255",
                Rule::unique("users", "email")->ignore($this->route("user")->id),
            ],
        ];
    }

    public function toDto(): UpdateManagedUserDto
    {
        return new UpdateManagedUserDto(
            name: $this->input("name"),
            email: $this->input("email"),
            hasName: $this->has("name"),
            hasEmail: $this->has("email"),
        );
    }
}
