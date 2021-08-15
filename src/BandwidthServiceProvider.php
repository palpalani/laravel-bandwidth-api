<?php

namespace palPalani\Bandwidth;

use palPalani\LaravelBandwidthApi\Commands\LaravelBandwidthApiCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BandwidthServiceProvider extends PackageServiceProvider
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

    public function register(): void
    {
        $config = $this->app->make('config');

        $this->app->bind('bandwidth', static function () use ($config): Mailgun {
            $config = new BandwidthLib\Configuration(
                array(
                    'messagingBasicAuthUserName' => $config->get('bandwidth.messaging.username'),
                    'messagingBasicAuthPassword' => $config->get('bandwidth.messaging.password'),
                    'voiceBasicAuthUserName' => $config->get('bandwidth.voice.username'),
                    'voiceBasicAuthPassword' => $config->get('bandwidth.voice.password'),
                    'twoFactorAuthBasicAuthUserName' => $config->get('bandwidth.twoFactor.username'),
                    'twoFactorAuthBasicAuthPassword' => $config->get('bandwidth.twoFactor.password'),
                    'webRtcBasicAuthUserName' => $config->get('bandwidth.webRtc.username'),
                    'webRtcBasicAuthPassword' => $config->get('bandwidth.webRtc.password'),
                )
            );
            return new BandwidthLib\BandwidthClient($config);
        });
    }
}
