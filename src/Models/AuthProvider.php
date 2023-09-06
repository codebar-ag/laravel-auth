<?php

namespace CodebarAg\LaravelAuth\Models;

use App\Models\User;
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
        return $this->belongsTo(User::class);
    }
}
