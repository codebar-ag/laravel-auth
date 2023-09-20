<?php

namespace CodebarAg\LaravelAuth\Observers;

use CodebarAg\LaravelAuth\Models\AuthProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthProviderObserver
{
    public function saving(AuthProvider $authProvider): void
    {
        $userModel = config('laravel-auth.model.user');

        $domain = parse_url(config('app.url'))['host'];

        $user = $userModel::updateOrCreate(
            [
                'id' => $authProvider->user_id,
            ],
            [
                'name' => $authProvider->name,
                'email' => Str::random(32).'@'.$domain,
                'password' => Hash::make(Str::random(32)),
            ]
        );

        $authProvider->user()->associate($user);
    }
}
