<?php

namespace CodebarAg\LaravelAuth\Controllers;

use CodebarAg\LaravelAuth\Jobs\RequestPasswordJob;
use CodebarAg\LaravelAuth\Requests\RequestPasswordRequest;

class RequestPasswordController
{
    public function index()
    {
        return view('auth::forgot-password');
    }

    public function store(RequestPasswordRequest $request)
    {
        RequestPasswordJob::dispatch($request->validated('email'));

        flash(__('passwords.sent'), 'success');

        return redirect()->back();
    }
}
