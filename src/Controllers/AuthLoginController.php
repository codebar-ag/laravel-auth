<?php


namespace CodebarAg\LaravelAuth\Controllers;

class AuthLoginController
{
    public function __invoke()
    {
        return view('laravel-auth::login');
    }
}
