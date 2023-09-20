<?php

namespace CodebarAg\LaravelAuth\Models;

use CodebarAg\LaravelAuth\Enums\ProviderEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthProvider extends Model
{
    protected $model;

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
        return $this->belongsTo($this->model::class);
    }
}
