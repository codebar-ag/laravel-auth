<?php

namespace CodebarAg\LaravelAuth\Controllers;


use CodebarAg\LaravelAuth\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function index()
    {
        return view('laravel-auth::login');
    }

    public function store(LoginRequest $loginRequest)
    {
        $credentials = [
            'email' => $loginRequest->email,
            'password' => $loginRequest->password,
        ];

        ray($credentials);
        if (! Auth::attempt($credentials, $loginRequest->remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $loginRequest->session()->regenerate();

        return redirect()->intended();
    }
}
