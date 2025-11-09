<?php

use BandwidthLib\Http\ApiResponse;
use palPalani\Bandwidth\Facades\Bandwidth;

it('can send message with full integration', function () {
    // Mock the bandwidth client for integration test
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    $mockResult = (object) [
        'id' => 'integration-msg-001',
        'status' => 'delivered',
        'time' => '2025-01-09T12:00:00Z',
        'from' => '+1234567890',
        'to' => ['+0987654321'],
    ];

    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->andReturn($mockResult);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->andReturn($mockResponse);

    app()->instance('bandwidth.client', $mockClient);

    // Send message
    $result = Bandwidth::sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'Integration test message'
    );

    // Verify result structure
    expect($result)
        ->toHaveKey('success', true)
        ->toHaveKey('message', 'Message sent successfully.')
        ->toHaveKey('id')
        ->toHaveKey('data');

    expect($result['id'])->toBe('integration-msg-001');
    expect($result['data']->status)->toBe('delivered');
});

it('handles error in integration scenario', function () {
    // Mock the bandwidth client for error scenario
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->andThrow(new \Exception('Insufficient balance'));

    app()->instance('bandwidth.client', $mockClient);

    $result = Bandwidth::sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'This will fail'
    );

    expect($result)
        ->toHaveKey('success', false)
        ->toHaveKey('message', 'Failed to send message.')
        ->toHaveKey('error', 'Insufficient balance');
});

it('can use dependency injection', function () {
    $bandwidth = app(\palPalani\Bandwidth\Bandwidth::class);

    expect($bandwidth)->toBeInstanceOf(\palPalani\Bandwidth\Bandwidth::class);
});

it('configuration is loaded correctly in integration', function () {
    expect(config('bandwidth.messaging.username'))->toBe('test-messaging-user');
    expect(config('bandwidth.messaging.account_id'))->toBe('test-account-id');
    expect(config('bandwidth.messaging.application_id'))->toBe('test-app-id');
});

it('can send tagged message in integration', function () {
    // Mock the bandwidth client
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    $mockResult = (object) [
        'id' => 'tagged-msg-001',
        'tag' => 'otp',
    ];

    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->andReturn($mockResult);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->andReturn($mockResponse);

    app()->instance('bandwidth.client', $mockClient);

    $result = Bandwidth::sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'Your OTP is 123456',
        tag: 'otp'
    );

    expect($result['success'])->toBeTrue();
    expect($result['data']->tag)->toBe('otp');
});
