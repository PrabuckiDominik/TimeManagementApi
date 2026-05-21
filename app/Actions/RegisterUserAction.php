<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Illuminate\Support\Facades\Hash;
use TimeManagement\DTO\RegisterUserDto;
use TimeManagement\Enums\Role;
use TimeManagement\Models\User;

class RegisterUserAction
{
    public function execute(RegisterUserDto $dto): ?User
    {
        if (User::query()->where("email", $dto->email)->exists()) {
            return null;
        }

        $user = User::create([
            "name" => $dto->name,
            "email" => $dto->email,
            "password" => Hash::make($dto->password),
        ]);

        $user->assignRole(Role::User->value);
        $user->sendEmailVerificationNotification();

        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event("registered")
            ->withProperties([
                "user_id" => $user->id,
                "email" => $user->email,
            ])
            ->log("Registered user");

        return $user;
    }
}
