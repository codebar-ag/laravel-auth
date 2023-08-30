<?php

namespace CodebarAg\LaravelAuth\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;
}
