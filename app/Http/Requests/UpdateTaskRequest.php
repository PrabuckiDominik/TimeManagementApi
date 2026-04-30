<?php

declare(strict_types=1);

namespace TimeManagement\Http\Requests;

class UpdateTaskRequest extends StoreTaskRequest
{
    public function rules(): array
    {
        return array_map(fn($rules) => array_merge(["sometimes"], $rules), parent::rules());
    }
}
