<?php

namespace CodebarAg\LaravelAuth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public function __construct(
        public string $token,
        public string $url,
        public int $expirationInMinutes,
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(__('Reset Password'), $this->url)
            ->line(__('This password reset link will expire in '.$this->expirationInMinutes.' minutes.'))
            ->line(__('If you did not request a password reset, no further action is required.'));
    }

    public function toArray($notifiable): array
    {
        return [
            'url' => $this->url,
            'expirationInMinutes' => $this->expirationInMinutes,
        ];
    }
}
