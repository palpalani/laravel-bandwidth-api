<?php

declare(strict_types=1);

namespace palPalani\Bandwidth;

use BandwidthLib\BandwidthClient;
use BandwidthLib\Configuration;
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
            ->hasConfigFile('bandwidth');
        //->hasViews()
        //->hasMigration('create_laravel-bandwidth-api_table')
    }

    public function packageRegistered(): void
    {
        $config = $this->app->make('config');

        $this->app->bind('bandwidth.client', static function () use ($config) {
            $config = new Configuration(
                [
                    'messagingBasicAuthUserName' => $config->get('bandwidth.messaging.username'),
                    'messagingBasicAuthPassword' => $config->get('bandwidth.messaging.password'),
                    'voiceBasicAuthUserName' => $config->get('bandwidth.voice.username'),
                    'voiceBasicAuthPassword' => $config->get('bandwidth.voice.password'),
                    'twoFactorAuthBasicAuthUserName' => $config->get('bandwidth.twoFactor.username'),
                    'twoFactorAuthBasicAuthPassword' => $config->get('bandwidth.twoFactor.password'),
                    'webRtcBasicAuthUserName' => $config->get('bandwidth.webRtc.username'),
                    'webRtcBasicAuthPassword' => $config->get('bandwidth.webRtc.password'),
                ]
            );

            return new BandwidthClient($config);
        });

        $this->app->singleton('bandwidth', static function () {
            return new Bandwidth();
        });

        $this->app->bind('phone', static function () use ($config) {
            return new \Iris\Client(
                $config->get('bandwidth.dashboard.username'),
                $config->get('bandwidth.dashboard.password'),
                ['url' => $config->get('bandwidth.dashboard.url')]
            );
        });
    }
}
