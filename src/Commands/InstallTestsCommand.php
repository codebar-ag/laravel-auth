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

        if (file_exists(base_path('phpunit.xml'))) {
            $this->replaceInFile('<testsuites>', '<testsuites>
        <testsuite name="Auth">
            <directory>tests/Auth</directory>
        </testsuite>', base_path('phpunit.xml')
            );
        }

        if (file_exists(base_path('phpunit.xml.dist'))) {
            $this->replaceInFile('<testsuites>', '<testsuites>
        <testsuite name="Auth">
            <directory>tests/Auth</directory>
        </testsuite>', base_path('phpunit.xml.dist')
            );
        }

        if (file_exists(base_path('tests/Pest.php'))) {
            $this->replaceInFile(')->in(\'Feature\'',
                ')->in(\'Feature\', \'Auth\'',
                base_path('tests/Pest.php')
            );
        }

        $this->comment('All done');

        return self::SUCCESS;
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
