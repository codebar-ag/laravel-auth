<?php

namespace CodebarAg\LaravelAuth\Controllers;

use CodebarAg\LaravelAuth\Enums\ProviderEnum;
use CodebarAg\LaravelAuth\Facades\LaravelAuth;
use CodebarAg\LaravelAuth\Models\AuthProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class ProviderController
{
    public function service($service)
    {
        $providerEnum = ProviderEnum::from($service);

        $fnName = $providerEnum->value;

        return $this->$fnName();
    }

    public function serviceRedirect($service)
    {
        $providerEnum = ProviderEnum::from($service);

        $provider = $providerEnum->value;

        $fnName = $provider.'Redirect';

        return $this->$fnName();
    }

    public function microsoft()
    {
        return Socialite::driver(ProviderEnum::MICROSOFT_OFFICE_365()->value)->redirect();
    }

    public function microsoftRedirect()
    {
        $socialiteUser = Socialite::driver(ProviderEnum::MICROSOFT_OFFICE_365()->value)->user();

        ray($socialiteUser);

        $provider = AuthProvider::firstOrCreate(
            [
                'provider' => ProviderEnum::MICROSOFT_OFFICE_365()->value,
                'provider_id' => $socialiteUser->id,
            ],
            [
                'token' => $socialiteUser->token,
                'refresh_token' => $socialiteUser->refreshToken,
            ]
        );

        if ($provider->wasRecentlyCreated) {
            $user = User::create([
                'name' => $socialiteUser->name,
                'email' => $socialiteUser->email,
            ]);

            $provider->update([
                'user_id' => $user->id,
            ]);

            $provider->refresh();
        }

        Auth::login($provider->user);

        return redirect()->intended();
    }
}
