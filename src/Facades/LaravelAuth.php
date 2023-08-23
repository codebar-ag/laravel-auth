<?php

namespace CodebarAg\LaravelAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodebarAg\LaravelAuth\LaravelAuth
 */
class LaravelAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \CodebarAg\LaravelAuth\LaravelAuth::class;
    }
}
