# Laravel BandWidth API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/palpalani/laravel-bandwidth-api.svg?style=flat-square)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/palpalani/laravel-bandwidth-api/run-tests?label=tests)](https://github.com/palpalani/laravel-bandwidth-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/palpalani/laravel-bandwidth-api/Check%20&%20fix%20styling?label=code%20style)](https://github.com/palpalani/laravel-bandwidth-api/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/palpalani/laravel-bandwidth-api.svg?style=flat-square)](https://packagist.org/packages/palpalani/laravel-bandwidth-api)

---
Simple wrapper for BandWidth API.

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

```php
$laravel-bandwidth-api = new palPalani\LaravelBandwidthApi();
echo $laravel-bandwidth-api->echoPhrase('Hello, Spatie!');
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
