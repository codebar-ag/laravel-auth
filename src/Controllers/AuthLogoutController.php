<?php


namespace CodebarAg\LaravelAuth\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthLogoutController
{
    public function __invoke()
    {
        Auth::logout();

        return redirect()->intended();
    }
}
