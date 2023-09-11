<?php

namespace CodebarAg\LaravelAuth\Tests\Auth\Fixtures;

use CodebarAg\LaravelAuth\Traits\HasAuthProviders;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class FixtureUser extends Authenticatable implements MustVerifyEmail
{
    use HasAuthProviders, Notifiable;
}
