<?php

namespace CodebarAg\LaravelAuth\Models;

use CodebarAg\LaravelAuth\Enums\ProviderEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $provider_id
 * @property string $provider
 */
class AuthProvider extends Model
{
    protected $model;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'name',
        'email',
        'token',
        'refresh_token',
    ];

    protected $casts = [
        'provider' => ProviderEnum::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->model = config('laravel-auth.model');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('laravel-auth.model.user'));
    }
}
