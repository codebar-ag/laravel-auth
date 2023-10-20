<?php

namespace CodebarAg\LaravelAuth\Controllers;

use CodebarAg\LaravelAuth\Enums\ProviderEnum;
use CodebarAg\LaravelAuth\Models\AuthProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController
{
    public function service($service)
    {
        $providerEnum = ProviderEnum::from($service);

        $this->allowed($providerEnum);

        $fnName = $providerEnum->value;

        return $this->$fnName();
    }

    public function serviceRedirect($service)
    {
        $providerEnum = ProviderEnum::from($service);

        $this->allowed($providerEnum);

        $provider = $providerEnum->value;

        $fnName = $provider.'Redirect';

        return $this->$fnName();
    }

    protected function allowed($provider)
    {
        if (!in_array($provider->value, config('laravel-auth.providers'))) {
            abort(503);
        }
    }

    public function microsoft()
    {
        return Socialite::driver(ProviderEnum::MICROSOFT_OFFICE_365()->value)->redirect();
    }

    public function microsoftRedirect()
    {
        $socialiteUser = Socialite::driver(ProviderEnum::MICROSOFT_OFFICE_365()->value)->user();

        $provider = AuthProvider::updateOrCreate(
            [
                'provider' => ProviderEnum::MICROSOFT_OFFICE_365()->value,
                'provider_id' => $socialiteUser->id,
            ],
            [
                'name' => $socialiteUser->name,
                'email' => $socialiteUser->email,

                'token' => $socialiteUser->token,
                'refresh_token' => $socialiteUser->refreshToken,
            ]
        );

        $provider->refresh();

        Auth::login($provider->user);

        return redirect()->intended();
    }
}
