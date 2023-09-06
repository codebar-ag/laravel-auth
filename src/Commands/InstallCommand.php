<?php

namespace CodebarAg\LaravelAuth\Commands;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Commands\InstallCommand as BaseInstallCommand;

class InstallCommand extends BaseInstallCommand
{

    public function __construct(Package $package)
    {
        parent::__construct($package);

        $this->signature = $package->name . ':install';
    }
}
