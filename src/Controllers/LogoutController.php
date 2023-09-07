<?php

namespace CodebarAg\LaravelAuth\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController
{
    public function __invoke(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended(
            config('laravel-auth.redirect.logout') ?
                route(config('laravel-auth.redirect.logout')) :
                '/'
        );
    }
}
