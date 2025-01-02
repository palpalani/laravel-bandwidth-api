# BandWidth API for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/palpalani/laravel-bandwidth-api.svg?style=flat-square)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/palpalani/laravel-bandwidth-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/palpalani/laravel-bandwidth-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/palpalani/laravel-bandwidth-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/palpalani/laravel-bandwidth-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/palpalani/laravel-bandwidth-api.svg?style=flat-square)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)

---
Simple Laravel wrapper for BandWidth API SDK.

## Installation

You can install the package via composer:

```bash
composer require palpalani/laravel-bandwidth-api
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="palPalani\LaravelBandwidthApi\LaravelBandwidthApiServiceProvider" --tag="laravel-bandwidth-api-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="palPalani\LaravelBandwidthApi\LaravelBandwidthApiServiceProvider" --tag="laravel-bandwidth-api-config"
```

This is the contents of the published config file:

```php
return [
    'messaging' => [
        'username' => env('BANDWIDTH_MESSAGING_USERNAME'),
        'password' => env('BANDWIDTH_MESSAGING_PASSWORD'),
    ],
    'voice' => [
        'username' => env('BANDWIDTH_VOICE_USERNAME'),
        'password' => env('BANDWIDTH_VOICE_PASSWORD'),
    ],
    'twoFactor' => [
        'username' => env('BANDWIDTH_TWO_FACTOR_USERNAME'),
        'password' => env('BANDWIDTH_TWO_FACTOR_PASSWORD'),
    ],
    'webRtc' => [
        'username' => env('BANDWIDTH_WEBRTC_USERNAME'),
        'password' => env('BANDWIDTH_WEBRTC_PASSWORD'),
    ],
];
```

## Usage

Sending basic SMS text message using Bandwidth API.

```php
$from = '';
$to = '';
$bandwidth = new palPalani\Bandwidth();
echo $bandwidth->sendMessage($from, $to, 'Hello, Greetings!');
```

Accessing dashboard API:

```php
$bandwidth = new palPalani\Bandwidth();
$account = $bandwidth->getAccount();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [palPalani](https://github.com/palpalani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
