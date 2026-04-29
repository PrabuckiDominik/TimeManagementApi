<?php

declare(strict_types=1);

namespace TimeManagement\Actions;

use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use TimeManagement\Models\User;

class LogoutUserAction
{
    public function execute(User $user): void
    {
        $token = $user->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        } else {
            Auth::guard("web")->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
    }
}
