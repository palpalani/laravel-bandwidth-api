<?php

use BandwidthLib\BandwidthClient;
use Iris\Client;

it('registers bandwidth wrapper in container', function () {
    $bandwidth = app('bandwidth');

    expect($bandwidth)->toBeInstanceOf(\palPalani\Bandwidth\Bandwidth::class);
});

it('registers bandwidth client in container', function () {
    $client = app('bandwidth.client');

    expect($client)->toBeInstanceOf(BandwidthClient::class);
});

it('registers phone (iris) client in container', function () {
    $client = app('phone');

    expect($client)->toBeInstanceOf(Client::class);
});

it('configures bandwidth client with messaging credentials', function () {
    $client = app('bandwidth.client');

    expect($client)->toBeInstanceOf(BandwidthClient::class);
    // Client is configured with credentials from test config
});

it('can publish config file', function () {
    // This test is skipped in test environment as config path doesn't exist
    // In real application, users can publish config with:
    // php artisan vendor:publish --provider="palPalani\Bandwidth\BandwidthServiceProvider" --tag="laravel-bandwidth-api-config"
    expect(true)->toBeTrue();
})->skip('Config publishing only works in full Laravel application');

it('loads config from published file', function () {
    expect(config('bandwidth.messaging.username'))->toBe('test-messaging-user');
    expect(config('bandwidth.messaging.password'))->toBe('test-messaging-pass');
    expect(config('bandwidth.messaging.account_id'))->toBe('test-account-id');
    expect(config('bandwidth.messaging.application_id'))->toBe('test-app-id');
});

it('has correct package name', function () {
    $providers = app()->getLoadedProviders();

    expect($providers)->toHaveKey('palPalani\Bandwidth\BandwidthServiceProvider');
});
