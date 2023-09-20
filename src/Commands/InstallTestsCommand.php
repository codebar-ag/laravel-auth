<?php

namespace CodebarAg\LaravelAuth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallTestsCommand extends Command
{
    public $signature = 'auth:install-tests';

    public $description = 'Install the auth tests';

    public function handle(): int
    {
        $this->comment('Publishing Auth Tests...');

        File::copyDirectory(__DIR__.'/../../stubs/tests/', base_path('tests'));

        $this->comment('All done');

        return self::SUCCESS;
    }
}
