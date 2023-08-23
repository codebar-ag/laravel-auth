<?php

namespace CodebarAg\LaravelAuth\Traits;

use CodebarAg\LaravelAuth\Models\AuthProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasAuthProviders
{
    public function authProviders(): HasMany
    {
        return $this->hasMany(AuthProvider::class);
    }
}
