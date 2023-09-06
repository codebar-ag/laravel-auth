<?php

namespace CodebarAg\LaravelAuth\Listeners;

class RayListener
{
    public function handle($event): void
    {
        ray('SPAM!');
    }
}
