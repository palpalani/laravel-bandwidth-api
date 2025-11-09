<?php

namespace palPalani\Bandwidth\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use palPalani\Bandwidth\BandwidthServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            BandwidthServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Bandwidth' => \palPalani\Bandwidth\Facades\Bandwidth::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        // Setup test configuration
        config()->set('bandwidth.messaging.username', 'test-messaging-user');
        config()->set('bandwidth.messaging.password', 'test-messaging-pass');
        config()->set('bandwidth.messaging.account_id', 'test-account-id');
        config()->set('bandwidth.messaging.application_id', 'test-app-id');

        config()->set('bandwidth.voice.username', 'test-voice-user');
        config()->set('bandwidth.voice.password', 'test-voice-pass');
        config()->set('bandwidth.voice.account_id', 'test-voice-account');

        config()->set('bandwidth.twoFactor.username', 'test-2fa-user');
        config()->set('bandwidth.twoFactor.password', 'test-2fa-pass');
        config()->set('bandwidth.twoFactor.account_id', 'test-2fa-account');

        config()->set('bandwidth.webRtc.username', 'test-webrtc-user');
        config()->set('bandwidth.webRtc.password', 'test-webrtc-pass');
        config()->set('bandwidth.webRtc.account_id', 'test-webrtc-account');

        config()->set('bandwidth.dashboard.username', 'test-dashboard-user');
        config()->set('bandwidth.dashboard.password', 'test-dashboard-pass');
        config()->set('bandwidth.dashboard.url', 'https://test.bandwidth.com/api/');
    }
}
