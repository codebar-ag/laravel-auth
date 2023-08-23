<?php

namespace CodebarAg\LaravelAuth\Observers;

use CodebarAg\LaravelAuth\Models\AuthProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthProviderObserver
{
    public function saving(AuthProvider $authProvider): void
    {
        $domain = parse_url(config('app.url'))['host'];

        $user = User::updateOrCreate(
            [
                'id' => $authProvider->user_id,
            ],
            [
                'name' => $authProvider->name,
                'email' => Str::random(32) . '@' . $domain,
                'password' => Hash::make(Str::random(32)),
            ]
        );

        $authProvider->user()->associate($user);
    }
}
