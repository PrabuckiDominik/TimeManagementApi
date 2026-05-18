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
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event("logged_out")
            ->log("User logged out");

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
