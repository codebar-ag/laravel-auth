<?php

namespace CodebarAg\LaravelAuth\Controllers;

use CodebarAg\LaravelAuth\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController
{
    public function index(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('frontend.start.index');
        }

        return view('laravel-auth::verify-email');
    }

    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('frontend.start.index');
        }

        $request->user()->notify(new VerifyEmailNotification());

        flash(__('A new verification link has been sent to the email address you provided during registration.'), 'success');

        return back();
    }

    public function store(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->intended();
    }
}
