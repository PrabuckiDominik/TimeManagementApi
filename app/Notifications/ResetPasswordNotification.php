<?php

declare(strict_types=1);

namespace TimeManagement\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__("passwords.reset_subject"))
            ->markdown("emails.auth.reset-password", [
                "url" => $this->frontendResetUrl($notifiable),
                "user" => $notifiable,
            ]);
    }

    private function frontendResetUrl($notifiable): string
    {
        return sprintf(
            "%s/reset-password/%s?email=%s",
            config("app.url"),
            $this->token,
            urlencode($notifiable->getEmailForPasswordReset()),
        );
    }
}
