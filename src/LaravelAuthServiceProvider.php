<?php

namespace CodebarAg\LaravelAuth;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use CodebarAg\LaravelAuth\Commands\LaravelAuthCommand;

class LaravelAuthServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-auth')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-auth_table')
            ->hasCommand(LaravelAuthCommand::class);
    }
}
