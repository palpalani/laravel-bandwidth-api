<?php

namespace palPalani\LaravelBandwidthApi\Commands;

use Illuminate\Console\Command;

class LaravelBandwidthApiCommand extends Command
{
    public $signature = 'laravel-bandwidth-api';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
