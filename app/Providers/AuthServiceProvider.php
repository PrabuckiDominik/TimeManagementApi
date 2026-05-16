<?php

declare(strict_types=1);

namespace TimeManagement\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        ResetPassword::createUrlUsing(
            fn(object $user, string $token): string => sprintf(
                "%s/reset-password/%s?email=%s",
                config("app.url"),
                $token,
                urlencode($user->email),
            ),
        );
    }
}
