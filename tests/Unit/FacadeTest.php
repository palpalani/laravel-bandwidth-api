<?php

use BandwidthLib\Http\ApiResponse;
use palPalani\Bandwidth\Facades\Bandwidth;

it('resolves facade to bandwidth instance', function () {
    $facade = Bandwidth::getFacadeRoot();

    expect($facade)->toBeInstanceOf(\palPalani\Bandwidth\Bandwidth::class);
});

it('sends message through facade', function () {
    // Mock the bandwidth client
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    $mockResult = (object) ['id' => 'facade-msg-123', 'status' => 'sent'];
    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->andReturn($mockResult);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->andReturn($mockResponse);

    app()->instance('bandwidth.client', $mockClient);

    $result = Bandwidth::sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'Facade test message'
    );

    expect($result)->toBeArray()
        ->toHaveKey('success', true)
        ->toHaveKey('id', 'facade-msg-123');
});

it('gets account through facade', function () {
    $account = Bandwidth::getAccount();

    expect($account)->toBeInstanceOf(\Iris\Account::class);
});

it('has correct facade accessor', function () {
    $accessor = (new ReflectionClass(\palPalani\Bandwidth\Facades\Bandwidth::class))
        ->getMethod('getFacadeAccessor')
        ->invoke(null);

    expect($accessor)->toBe('bandwidth');
});

it('facade is registered as alias', function () {
    $aliases = app()->getAlias('Bandwidth');

    expect($aliases)->toBe('Bandwidth');
});
