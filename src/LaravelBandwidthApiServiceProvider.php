<?php

namespace palPalani\LaravelBandwidthApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use palPalani\LaravelBandwidthApi\Commands\LaravelBandwidthApiCommand;

class LaravelBandwidthApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-bandwidth-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-bandwidth-api_table')
            ->hasCommand(LaravelBandwidthApiCommand::class);
    }
}
