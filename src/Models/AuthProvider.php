<?php

namespace CodebarAg\LaravelAuth\Models;

use CodebarAg\LaravelAuth\Enums\ProviderEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthProvider extends Model
{
    protected $casts = [
        'provider' => ProviderEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('laravel-auth.model.user'));
    }
}
