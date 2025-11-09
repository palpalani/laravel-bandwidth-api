<?php

use BandwidthLib\Http\ApiResponse;
use BandwidthLib\Messaging\Models\MessageRequest;
use Iris\Account;
use palPalani\Bandwidth\Bandwidth;

beforeEach(function () {
    $this->bandwidth = new Bandwidth();
});

it('instantiates bandwidth class', function () {
    expect($this->bandwidth)->toBeInstanceOf(Bandwidth::class);
});

it('sends message successfully', function () {
    // Mock the bandwidth client
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    // Mock successful API response
    $mockResult = (object) ['id' => 'msg-123', 'status' => 'sent'];
    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->andReturn($mockResult);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->with('test-account-id', Mockery::type(MessageRequest::class))
        ->andReturn($mockResponse);

    app()->instance('bandwidth.client', $mockClient);

    $result = $this->bandwidth->sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'Test message'
    );

    expect($result)->toBeArray()
        ->toHaveKey('success', true)
        ->toHaveKey('message', 'Message sent successfully.')
        ->toHaveKey('id', 'msg-123')
        ->toHaveKey('data');
});

it('handles message sending failure', function () {
    // Mock the bandwidth client
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->andThrow(new \Exception('API Error: Invalid credentials'));

    app()->instance('bandwidth.client', $mockClient);

    $result = $this->bandwidth->sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'Test message'
    );

    expect($result)->toBeArray()
        ->toHaveKey('success', false)
        ->toHaveKey('message', 'Failed to send message.')
        ->toHaveKey('error', 'API Error: Invalid credentials');
});

it('sends message with optional tag parameter', function () {
    // Mock the bandwidth client
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    // Mock successful API response
    $mockResult = (object) ['id' => 'msg-456', 'status' => 'sent', 'tag' => 'verification'];
    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->andReturn($mockResult);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->with('test-account-id', Mockery::on(function ($messageRequest) {
            return $messageRequest->tag === 'verification';
        }))
        ->andReturn($mockResponse);

    app()->instance('bandwidth.client', $mockClient);

    $result = $this->bandwidth->sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'Your code is 123456',
        tag: 'verification'
    );

    expect($result)->toBeArray()
        ->toHaveKey('success', true)
        ->toHaveKey('id', 'msg-456');
});

it('sends message to multiple recipients', function () {
    // Mock the bandwidth client
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    $mockResult = (object) ['id' => 'msg-789', 'status' => 'sent'];
    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->andReturn($mockResult);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->with('test-account-id', Mockery::on(function ($messageRequest) {
            return count($messageRequest->to) === 3;
        }))
        ->andReturn($mockResponse);

    app()->instance('bandwidth.client', $mockClient);

    $result = $this->bandwidth->sendMessage(
        from: '+1234567890',
        to: ['+0987654321', '+1122334455', '+9988776655'],
        text: 'Broadcast message'
    );

    expect($result)->toBeArray()
        ->toHaveKey('success', true);
});

it('uses application_id from config', function () {
    // Mock the bandwidth client
    $mockMessagingClient = Mockery::mock();
    $mockClient = Mockery::mock();
    $mockClient->shouldReceive('getMessaging->getClient')->andReturn($mockMessagingClient);

    $mockResult = (object) ['id' => 'msg-config', 'status' => 'sent'];
    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->andReturn($mockResult);

    $mockMessagingClient->shouldReceive('createMessage')
        ->once()
        ->with('test-account-id', Mockery::on(function ($messageRequest) {
            return $messageRequest->applicationId === 'test-app-id';
        }))
        ->andReturn($mockResponse);

    app()->instance('bandwidth.client', $mockClient);

    $result = $this->bandwidth->sendMessage(
        from: '+1234567890',
        to: ['+0987654321'],
        text: 'Config test'
    );

    expect($result)->toBeArray()
        ->toHaveKey('success', true);
});

it('returns account instance', function () {
    $account = $this->bandwidth->getAccount();

    expect($account)->toBeInstanceOf(Account::class);
});

it('extracts result from API response', function () {
    $mockResult = (object) ['id' => 'test-id', 'data' => 'test-data'];
    $mockResponse = Mockery::mock(ApiResponse::class);
    $mockResponse->shouldReceive('getResult')->once()->andReturn($mockResult);

    $extractResult = new ReflectionMethod($this->bandwidth, 'extractResult');
    $extractResult->setAccessible(true);

    $result = $extractResult->invoke($this->bandwidth, $mockResponse);

    expect($result)->toBe($mockResult);
});

it('throws exception for unexpected response type', function () {
    $extractResult = new ReflectionMethod($this->bandwidth, 'extractResult');
    $extractResult->setAccessible(true);

    $extractResult->invoke($this->bandwidth, 'invalid-response');
})->throws(\RuntimeException::class, 'Unexpected response type.');
