<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use TimeManagement\DTO\RegisterUserDto;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:225"],
            "email" => ["required", "email", "max:225"],
            "password" => ["required", "confirmed", Password::min(8)],
        ];
    }

    public function toDto(): RegisterUserDto
    {
        return new RegisterUserDto(
            name: $this->input("name"),
            email: $this->input("email"),
            password: $this->input("password"),
        );
    }
}
