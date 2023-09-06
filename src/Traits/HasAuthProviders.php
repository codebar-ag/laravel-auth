<?php

namespace CodebarAg\LaravelAuth\Traits;

use CodebarAg\LaravelAuth\Models\AuthProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notification;

trait HasAuthProviders
{
    public function authProviders(): HasMany
    {
        return $this->hasMany(AuthProvider::class);
    }

    protected function contactEmail(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->authProviders()->exists()) {
                    return $this->email;
                }

                return $this->authProviders()->first()->email;
            },
        );
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
        return $notification->id = $this->contact_email;
    }
}
