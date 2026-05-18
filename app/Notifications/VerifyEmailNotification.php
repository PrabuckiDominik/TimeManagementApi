<?php

declare(strict_types=1);

namespace TimeManagement\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__("auth.verify_email_subject"))
            ->markdown("emails.auth.verify-email", [
                "url" => $this->verificationUrl($notifiable),
                "user" => $notifiable,
            ]);
    }
}
