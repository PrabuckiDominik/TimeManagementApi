<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Models\User;

class EmailVerificationController extends Controller
{
    public function verify(int $id, string $hash): RedirectResponse
    {
        $user = User::query()->find($id);

        if (!$user) {
            return redirect()
                ->to(config("app.url") . "/login?verified=user_not_found")
                ->setStatusCode(Status::HTTP_NOT_FOUND);
        }

        if (!hash_equals(
            sha1($user->getEmailForVerification()),
            $hash,
        )) {
            return redirect()
                ->to(config("app.url") . "/login?verified=invalid")
                ->setStatusCode(Status::HTTP_FORBIDDEN);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->to(config("app.url") . "/login?verified=already")
                ->setStatusCode(Status::HTTP_OK);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()
            ->to(config("app.url") . "/login?verified=success")
            ->setStatusCode(Status::HTTP_OK);
    }
}
