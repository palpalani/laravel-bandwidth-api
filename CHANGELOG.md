# Changelog

All notable changes to `laravel-bandwidth-api` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.7.0] - 2025-03-13

### Added
- Support for Laravel 12

## [0.6.0] - 2025-01-06

### Added
- Optional tag parameter to `sendMessage()` method for message tagging
- Support for nullable tag parameter in MessageRequest

### Changed
- **BREAKING**: `sendMessage()` method signature now accepts optional tag parameter

## [0.5.0] - 2025-01-06

### Added
- Structured response format for `sendMessage()` with success/error states
- Message ID extraction from successful API responses
- Comprehensive error handling with detailed error messages

### Changed
- **BREAKING**: `sendMessage()` now returns array with `success`, `message`, and `data`/`error` keys instead of raw response
- Improved response handling using `extractResult()` method

### Fixed
- Removed debug `print_r` statements in favor of proper return values

## [0.4.0] - 2025-01-02

### Added
- Configuration-based `application_id` for messaging API
- `BANDWIDTH_MESSAGING_APPLICATION_ID` environment variable support
- New config key: `bandwidth.messaging.application_id`

### Changed
- **BREAKING**: `applicationId` now sourced from config instead of hardcoded value
- **BREAKING**: Removed `applicationId` parameter from `sendMessage()` method - now uses config value

### Fixed
- Hardcoded `applicationId` value replaced with configurable option

## [0.3.0] - 2024-12-27

### Added
- Support for PHP 8.4
- Support for Bandwidth SDK 11.x
- Support for Pest 3.x testing framework
- Support for Larastan 3.x static analysis

### Changed
- Updated dependency constraints for modern tooling

## [0.2.0] - 2024-02-25

### Added
- Support for Laravel 11

## [0.1.0] - 2022-01-01

### Added
- Initial release
- Laravel service provider and facade for Bandwidth API
- Messaging API integration for SMS and MMS
- Voice API integration for calls and recordings
- Two-Factor authentication API integration
- WebRTC API integration for browser-based communications
- Dashboard API access for account management
- Configuration file with environment variable support
- Comprehensive documentation and examples

[Unreleased]: https://github.com/palpalani/laravel-bandwidth-api/compare/0.7.0...HEAD
[0.7.0]: https://github.com/palpalani/laravel-bandwidth-api/compare/0.6.0...0.7.0
[0.6.0]: https://github.com/palpalani/laravel-bandwidth-api/compare/0.5.0...0.6.0
[0.5.0]: https://github.com/palpalani/laravel-bandwidth-api/compare/0.4.0...0.5.0
[0.4.0]: https://github.com/palpalani/laravel-bandwidth-api/compare/0.3.0...0.4.0
[0.3.0]: https://github.com/palpalani/laravel-bandwidth-api/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/palpalani/laravel-bandwidth-api/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/palpalani/laravel-bandwidth-api/releases/tag/0.1.0
