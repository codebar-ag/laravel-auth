<?php

namespace CodebarAg\LaravelAuth\Traits;

use CodebarAg\LaravelAuth\Enums\ProviderEnum;
use CodebarAg\LaravelAuth\Models\AuthProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notification;

trait HasAuthProviders
{
    public function authProviders(): HasMany
    {
        return $this->hasMany(AuthProvider::class);
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
        if (!$this->authProviders()->exists()) {
            $notification->id = $this->email;
            return $this->email;
        }

        $notification->id = $this->authProviders()->first()->email;
        return $this->authProviders()->first()->email;
    }
}
