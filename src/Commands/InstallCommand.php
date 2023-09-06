<?php

namespace CodebarAg\LaravelAuth\Commands;

use Spatie\LaravelPackageTools\Commands\InstallCommand as BaseInstallCommand;
use Spatie\LaravelPackageTools\Package;

class InstallCommand extends BaseInstallCommand
{
    public function __construct(Package $package)
    {
        parent::__construct($package);

        $this->signature = $package->name.':install';
    }
}
