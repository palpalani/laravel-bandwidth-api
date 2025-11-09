# Bandwidth API for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/palpalani/laravel-bandwidth-api.svg?style=flat-square)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)
[![PHP Version](https://img.shields.io/packagist/dependency-v/palpalani/laravel-bandwidth-api/php?style=flat-square)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)
[![Laravel Version](https://img.shields.io/badge/Laravel-10.x%20|%2011.x%20|%2012.x-FF2D20?style=flat-square&logo=laravel)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/palpalani/laravel-bandwidth-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/palpalani/laravel-bandwidth-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/palpalani/laravel-bandwidth-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/palpalani/laravel-bandwidth-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/palpalani/laravel-bandwidth-api.svg?style=flat-square)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)
[![License](https://img.shields.io/packagist/l/palpalani/laravel-bandwidth-api?style=flat-square)](https://github.com/palpalani/laravel-bandwidth-api/blob/main/LICENSE.md)

---

A simple, elegant Laravel wrapper for the [Bandwidth API](https://www.bandwidth.com/). Send SMS/MMS messages, make voice calls, implement two-factor authentication, and integrate WebRTC communications into your Laravel applications with ease.

## Features

- 📱 **SMS/MMS Messaging** - Send text and multimedia messages with media attachments
- 📞 **Voice API** - Manage inbound and outbound voice calls
- 🔐 **Two-Factor Authentication** - Implement 2FA with voice or SMS
- 🌐 **WebRTC** - Browser-based real-time communications
- 🔍 **Phone Number Lookup** - Validate and lookup phone number information
- 🎛️ **Dashboard API** - Manage your Bandwidth account programmatically
- ✨ **Structured Responses** - Consistent error handling and response format
- 🎯 **Message Tagging** - Organize and track messages with custom tags
- 🏗️ **Laravel Integration** - Service provider, facade, and dependency injection support

## Requirements

- PHP 8.3 or higher
- Laravel 11.x, or 12.x
- A [Bandwidth account](https://www.bandwidth.com/) with API credentials

## Installation

Install the package via Composer:

```bash
composer require palpalani/laravel-bandwidth-api
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="palPalani\Bandwidth\BandwidthServiceProvider" --tag="laravel-bandwidth-api-config"
```

This will create a `config/bandwidth.php` configuration file.

## Configuration

Add your Bandwidth API credentials to your `.env` file:

```env
# Messaging API (SMS/MMS)
BANDWIDTH_MESSAGING_USERNAME=your-messaging-username
BANDWIDTH_MESSAGING_PASSWORD=your-messaging-password
BANDWIDTH_MESSAGING_ACCOUNT_ID=your-account-id
BANDWIDTH_MESSAGING_APPLICATION_ID=your-application-id

# Voice API
BANDWIDTH_VOICE_USERNAME=your-voice-username
BANDWIDTH_VOICE_PASSWORD=your-voice-password
BANDWIDTH_VOICE_ACCOUNT_ID=your-voice-account-id

# Two-Factor Authentication
BANDWIDTH_TWO_FACTOR_USERNAME=your-2fa-username
BANDWIDTH_TWO_FACTOR_PASSWORD=your-2fa-password
BANDWIDTH_TWO_FACTOR_ACCOUNT_ID=your-2fa-account-id

# WebRTC
BANDWIDTH_WEBRTC_USERNAME=your-webrtc-username
BANDWIDTH_WEBRTC_PASSWORD=your-webrtc-password
BANDWIDTH_WEBRTC_ACCOUNT_ID=your-webrtc-account-id

# Dashboard/IRIS API (for account management)
BANDWIDTH_DASHBOARD_USERNAME=your-dashboard-username
BANDWIDTH_DASHBOARD_PASSWORD=your-dashboard-password
BANDWIDTH_DASHBOARD_API_URL=https://dashboard.bandwidth.com/api/
```

### Published Configuration File

The `config/bandwidth.php` file contains the following structure:

```php
return [
    'messaging' => [
        'username' => env('BANDWIDTH_MESSAGING_USERNAME'),
        'password' => env('BANDWIDTH_MESSAGING_PASSWORD'),
        'account_id' => env('BANDWIDTH_MESSAGING_ACCOUNT_ID'),
        'application_id' => env('BANDWIDTH_MESSAGING_APPLICATION_ID'),
    ],

    'voice' => [
        'username' => env('BANDWIDTH_VOICE_USERNAME'),
        'password' => env('BANDWIDTH_VOICE_PASSWORD'),
        'account_id' => env('BANDWIDTH_VOICE_ACCOUNT_ID'),
    ],

    'twoFactor' => [
        'username' => env('BANDWIDTH_TWO_FACTOR_USERNAME'),
        'password' => env('BANDWIDTH_TWO_FACTOR_PASSWORD'),
        'account_id' => env('BANDWIDTH_TWO_FACTOR_ACCOUNT_ID'),
    ],

    'webRtc' => [
        'username' => env('BANDWIDTH_WEBRTC_USERNAME'),
        'password' => env('BANDWIDTH_WEBRTC_PASSWORD'),
        'account_id' => env('BANDWIDTH_WEBRTC_ACCOUNT_ID'),
    ],

    'dashboard' => [
        'username' => env('BANDWIDTH_DASHBOARD_USERNAME'),
        'password' => env('BANDWIDTH_DASHBOARD_PASSWORD'),
        'url' => env('BANDWIDTH_DASHBOARD_API_URL', 'https://dashboard.bandwidth.com/api/'),
    ],
];
```

> **Note:** You don't need credentials for all APIs. Configure only the services you plan to use.

### Getting Your Credentials

1. Sign up for a [Bandwidth account](https://www.bandwidth.com/)
2. Navigate to your [Bandwidth Dashboard](https://dashboard.bandwidth.com/)
3. Create API credentials for the services you need
4. For messaging, create an Application to get your `application_id`
5. Your `account_id` can be found in your account settings

## Usage

### Basic SMS Messaging

Using the Facade:

```php
use palPalani\Bandwidth\Facades\Bandwidth;

$result = Bandwidth::sendMessage(
    from: '+1234567890',
    to: ['+0987654321'],
    text: 'Hello from Laravel!'
);

if ($result['success']) {
    echo "Message sent! ID: {$result['id']}";
} else {
    echo "Error: {$result['error']}";
}
```

Using Dependency Injection:

```php
use palPalani\Bandwidth\Bandwidth;

class NotificationService
{
    public function __construct(
        private Bandwidth $bandwidth
    ) {}

    public function sendAlert(string $phone, string $message): array
    {
        return $this->bandwidth->sendMessage(
            from: config('app.sms_from_number'),
            to: [$phone],
            text: $message
        );
    }
}
```

### Message Tagging

Organize and track messages with custom tags (available since v0.6.0):

```php
$result = Bandwidth::sendMessage(
    from: '+1234567890',
    to: ['+0987654321'],
    text: 'Your verification code is: 123456',
    tag: 'verification-code'
);
```

### Response Structure

All `sendMessage()` calls return a structured array (since v0.5.0):

**Success Response:**
```php
[
    'success' => true,
    'message' => 'Message sent successfully.',
    'id' => 'message-id-from-bandwidth',
    'data' => [...] // Full API response object
]
```

**Error Response:**
```php
[
    'success' => false,
    'message' => 'Failed to send message.',
    'error' => 'Detailed error message from API'
]
```

### Error Handling

```php
$result = Bandwidth::sendMessage(
    from: '+1234567890',
    to: ['+0987654321'],
    text: 'Test message'
);

if ($result['success']) {
    // Success - message sent
    $messageId = $result['id'];
    $fullResponse = $result['data'];

    // Store message ID for tracking
    \Log::info("SMS sent successfully", ['id' => $messageId]);
} else {
    // Error occurred
    $errorMessage = $result['error'];

    // Log error for debugging
    \Log::error("SMS failed", ['error' => $errorMessage]);

    // Notify user or retry
    throw new \Exception("Could not send SMS: {$errorMessage}");
}
```

### Dashboard API Access

Access your Bandwidth account information:

```php
$account = Bandwidth::getAccount();

// Now you can use the Iris\Account object to manage your account
// See Bandwidth IRIS API documentation for available methods
```

### Advanced: Direct SDK Access

For advanced use cases, access the underlying Bandwidth SDK clients directly:

```php
// Get the main Bandwidth client
$client = app('bandwidth');

// Access specific API clients
$messagingClient = $client->getMessaging();
$voiceClient = $client->getVoice();
$webRtcClient = $client->getWebRtc();
$mfaClient = $client->getMultiFactorAuth();
$lookupClient = $client->getPhoneNumberLookup();

// Access Dashboard/IRIS client
$irisClient = app('phone');
```

## API Reference

### Bandwidth Class

#### `sendMessage()`

Send an SMS or MMS message.

```php
public function sendMessage(
    string $from,
    array $to,
    string $text,
    string|null $tag = null
): array
```

**Parameters:**
- `$from` - The phone number to send from (E.164 format)
- `$to` - Array of recipient phone numbers (E.164 format)
- `$text` - The message text content
- `$tag` - Optional tag for organizing messages (since v0.6.0)

**Returns:** Array with keys:
- `success` (bool) - Whether the operation succeeded
- `message` (string) - Human-readable status message
- `id` (string|null) - Bandwidth message ID on success
- `data` (object) - Full API response on success
- `error` (string) - Error message on failure

#### `getAccount()`

Get the Bandwidth account object for dashboard operations.

```php
public function getAccount(): Iris\Account
```

**Returns:** `Iris\Account` object for account management

## Environment Variables

| Variable | Required | Description | Example |
|----------|----------|-------------|---------|
| `BANDWIDTH_MESSAGING_USERNAME` | For SMS/MMS | Messaging API username | `api-user-123` |
| `BANDWIDTH_MESSAGING_PASSWORD` | For SMS/MMS | Messaging API password | `api-password-456` |
| `BANDWIDTH_MESSAGING_ACCOUNT_ID` | For SMS/MMS | Your Bandwidth account ID | `1234567` |
| `BANDWIDTH_MESSAGING_APPLICATION_ID` | For SMS/MMS | Messaging application ID | `app-abc123` |
| `BANDWIDTH_VOICE_USERNAME` | For Voice | Voice API username | `voice-user-123` |
| `BANDWIDTH_VOICE_PASSWORD` | For Voice | Voice API password | `voice-pass-456` |
| `BANDWIDTH_VOICE_ACCOUNT_ID` | For Voice | Voice account ID | `1234567` |
| `BANDWIDTH_TWO_FACTOR_USERNAME` | For 2FA | Two-factor API username | `2fa-user-123` |
| `BANDWIDTH_TWO_FACTOR_PASSWORD` | For 2FA | Two-factor API password | `2fa-pass-456` |
| `BANDWIDTH_TWO_FACTOR_ACCOUNT_ID` | For 2FA | Two-factor account ID | `1234567` |
| `BANDWIDTH_WEBRTC_USERNAME` | For WebRTC | WebRTC API username | `webrtc-user-123` |
| `BANDWIDTH_WEBRTC_PASSWORD` | For WebRTC | WebRTC API password | `webrtc-pass-456` |
| `BANDWIDTH_WEBRTC_ACCOUNT_ID` | For WebRTC | WebRTC account ID | `1234567` |
| `BANDWIDTH_DASHBOARD_USERNAME` | For Dashboard | Dashboard/IRIS username | `dashboard-user-123` |
| `BANDWIDTH_DASHBOARD_PASSWORD` | For Dashboard | Dashboard/IRIS password | `dashboard-pass-456` |
| `BANDWIDTH_DASHBOARD_API_URL` | Optional | Dashboard API endpoint | `https://dashboard.bandwidth.com/api/` |

## Testing

Run the test suite:

```bash
composer test
```

Run static analysis:

```bash
composer analyse
```

Fix code style issues:

```bash
composer format
```

### Testing Your Integration

When testing, you can use Bandwidth's test credentials or mock the `Bandwidth` class:

```php
use palPalani\Bandwidth\Facades\Bandwidth;

// In your tests
Bandwidth::shouldReceive('sendMessage')
    ->once()
    ->with('+1234567890', ['+0987654321'], 'Test message', null)
    ->andReturn([
        'success' => true,
        'message' => 'Message sent successfully.',
        'id' => 'test-message-id',
        'data' => (object) ['id' => 'test-message-id'],
    ]);
```

## Troubleshooting

### Common Issues

**Problem:** "Application ID not configured"
- **Solution:** Ensure `BANDWIDTH_MESSAGING_APPLICATION_ID` is set in your `.env` file. This is required since v0.4.0.

**Problem:** "Invalid phone number format"
- **Solution:** Use E.164 format for phone numbers (e.g., `+1234567890`). Include the country code with `+` prefix.

**Problem:** "The `to` parameter must be an array"
- **Solution:** Always pass recipient numbers as an array: `to: ['+1234567890']` not `to: '+1234567890'`

**Problem:** "Unexpected response type"
- **Solution:** This usually indicates an API version mismatch. Ensure you're using compatible versions of `bandwidth/sdk` and `bandwidth/iris`.

### Enable Debug Logging

Add logging to debug issues:

```php
\Log::debug('Sending Bandwidth message', [
    'from' => $from,
    'to' => $to,
    'text' => $text,
]);

$result = Bandwidth::sendMessage($from, $to, $text);

\Log::debug('Bandwidth response', $result);
```

### Check API Status

Visit [Bandwidth Status Page](https://status.bandwidth.com/) to check for service outages.

## Upgrade Guide

### Upgrading to v0.6.0 from v0.5.0

**New Feature:** Optional `tag` parameter added to `sendMessage()`.

```php
// Before (still works)
Bandwidth::sendMessage($from, $to, $text);

// After (optional tag parameter)
Bandwidth::sendMessage($from, $to, $text, 'my-tag');
```

No breaking changes - fully backward compatible.

### Upgrading to v0.5.0 from v0.4.0

**Breaking Change:** `sendMessage()` response structure changed.

**Before (v0.4.0):**
```php
// Returned mixed response or threw exceptions
$response = Bandwidth::sendMessage($from, $to, $text);
```

**After (v0.5.0):**
```php
// Returns structured array
$result = Bandwidth::sendMessage($from, $to, $text);

if ($result['success']) {
    $messageId = $result['id'];
} else {
    $error = $result['error'];
}
```

**Migration Steps:**
1. Update all `sendMessage()` calls to handle the new array response
2. Replace exception handling with `$result['success']` checks
3. Update tests to expect the new response structure

### Upgrading to v0.4.0 from v0.3.0

**Breaking Change:** Removed `$applicationId` parameter from `sendMessage()`.

**Before (v0.3.0):**
```php
Bandwidth::sendMessage($from, $to, $text, $applicationId);
```

**After (v0.4.0):**
```php
// applicationId now comes from config
Bandwidth::sendMessage($from, $to, $text);
```

**Migration Steps:**
1. Add `BANDWIDTH_MESSAGING_APPLICATION_ID` to your `.env` file
2. Remove the `$applicationId` parameter from all `sendMessage()` calls
3. Republish the config if you published it before v0.4.0

## FAQ

**Q: Do I need to configure all API credentials?**
A: No, only configure the services you plan to use. For example, if you only need SMS, just set the messaging credentials.

**Q: What's the difference between `account_id` and `application_id`?**
A: The `account_id` is your Bandwidth account identifier. The `application_id` is specific to your messaging application created in the Bandwidth dashboard. You need both for messaging.

**Q: Can I send messages to multiple recipients?**
A: Yes, pass an array of phone numbers to the `to` parameter. Bandwidth will send individual messages to each recipient.

**Q: How do I send MMS with images?**
A: Currently, the package's `sendMessage()` helper focuses on text messages. For MMS with media, use the direct SDK access to set the `media` property on the `MessageRequest` object.

**Q: Is there a rate limit?**
A: Yes, Bandwidth enforces rate limits. Check your account's rate limits in the Bandwidth dashboard and implement appropriate throttling in your application.

**Q: How can I track message delivery status?**
A: Configure webhooks in your Bandwidth dashboard to receive delivery receipts. The package returns a message ID that you can use to correlate webhook callbacks.

**Q: Does this support Laravel Vapor/serverless?**
A: Yes, the package is stateless and works with serverless deployments like Laravel Vapor.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

We welcome contributions! Whether it's:
- Bug reports and fixes
- Feature requests and implementations
- Documentation improvements
- Code quality enhancements

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

**Never commit your Bandwidth API credentials to version control.** Always use environment variables and keep your `.env` file secure.

## Credits

- [palPalani](https://github.com/palpalani)
- [All Contributors](../../contributors)

This package is a Laravel wrapper for the official [Bandwidth SDK](https://github.com/Bandwidth/php-sdk). Special thanks to Bandwidth for providing excellent communications APIs.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Resources

- [Bandwidth Developer Documentation](https://dev.bandwidth.com/)
- [Bandwidth API Reference](https://dev.bandwidth.com/apis/)
- [Bandwidth PHP SDK](https://github.com/Bandwidth/php-sdk)
- [Bandwidth IRIS SDK](https://github.com/Bandwidth/php-bandwidth-iris)
- [Package Documentation](https://github.com/palpalani/laravel-bandwidth-api)

---

**Note:** This is an unofficial Laravel package. Bandwidth® is a registered trademark of Bandwidth Inc.
