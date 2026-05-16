<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TimeManagement\DTO\StoreTagDto;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
        ];
    }

    public function toDto(): StoreTagDto
    {
        return new StoreTagDto(
            name: $this->input("name"),
        );
    }
}
