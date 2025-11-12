<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email" => ["required", "email", "max:225"],
        ];
    }
}
