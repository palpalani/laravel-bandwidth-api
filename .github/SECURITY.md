# Security Policy

## Our Commitment

We take the security of `laravel-bandwidth-api` seriously. This includes protecting user data, API credentials, and ensuring the package doesn't introduce vulnerabilities into applications that use it.

## Supported Versions

We actively support the following versions with security updates:

| Version | Supported          | PHP Support | Laravel Support |
| ------- | ------------------ | ----------- | --------------- |
| 0.7.x   | :white_check_mark: | 8.3, 8.4    | 11.x, 12.x      |
| 0.6.x   | :white_check_mark: | 8.3, 8.4    | 11.x, 12.x      |
| 0.5.x   | :x:                | 8.3, 8.4    | 11.x, 12.x      |
| 0.4.x   | :x:                | 8.3, 8.4    | 11.x, 12.x      |
| < 0.4   | :x:                | -           | -               |

**Note:** We provide security updates for the current major version and the previous minor version. Older versions are no longer supported.

## Reporting a Vulnerability

**Please do NOT report security vulnerabilities through public GitHub issues.**

If you discover a security vulnerability, please report it privately using one of the following methods:

### Preferred Method: GitHub Security Advisories

1. Go to the [Security tab](https://github.com/palpalani/laravel-bandwidth-api/security/advisories)
2. Click "Report a vulnerability"
3. Fill out the form with details about the vulnerability
4. Submit the report

### Alternative Method: Email

Email security reports to: **palani.p@gmail.com**

**Please include:**
- Description of the vulnerability
- Steps to reproduce the issue
- Potential impact
- Suggested fix (if any)
- Your contact information

### What to Expect

When you report a security issue, you can expect:

1. **Acknowledgment** - Within 48 hours of your report
2. **Initial Assessment** - Within 5 business days
3. **Regular Updates** - Every 7 days until resolution
4. **Fix Timeline** - Critical issues within 7 days, high severity within 14 days
5. **Disclosure** - Coordinated disclosure after fix is released
6. **Credit** - Recognition in security advisory (if desired)

## Security Update Process

When a security vulnerability is reported:

1. **Verification** - We verify and assess the severity
2. **Fix Development** - We develop and test a fix
3. **Security Release** - We release a patch version
4. **Advisory Publication** - We publish a security advisory
5. **Notification** - We notify users through GitHub and package channels

## Security Best Practices for Users

When using `laravel-bandwidth-api`, follow these security best practices:

### 1. Protect API Credentials

**Never commit credentials to version control:**

```bash
# .gitignore should include:
.env
.env.*
!.env.example
```

**Use environment variables:**

```env
BANDWIDTH_MESSAGING_USERNAME=your-username
BANDWIDTH_MESSAGING_PASSWORD=your-password
BANDWIDTH_MESSAGING_ACCOUNT_ID=your-account-id
BANDWIDTH_MESSAGING_APPLICATION_ID=your-app-id
```

### 2. Validate User Input

Always validate and sanitize user input before passing to Bandwidth API:

```php
use Illuminate\Support\Facades\Validator;

$validator = Validator::make($request->all(), [
    'phone' => 'required|regex:/^\+[1-9]\d{1,14}$/',
    'message' => 'required|string|max:1600',
]);

if ($validator->fails()) {
    // Handle validation errors
}

$result = Bandwidth::sendMessage(
    from: config('app.sms_from'),
    to: [$validator->validated()['phone']],
    text: $validator->validated()['message']
);
```

### 3. Rate Limiting

Implement rate limiting to prevent abuse:

```php
use Illuminate\Support\Facades\RateLimiter;

if (RateLimiter::tooManyAttempts('send-sms:' . $user->id, 10)) {
    return response()->json(['error' => 'Too many requests'], 429);
}

RateLimiter::hit('send-sms:' . $user->id, 60);
```

### 4. Audit Logging

Log all SMS/voice operations for security auditing:

```php
use Illuminate\Support\Facades\Log;

$result = Bandwidth::sendMessage($from, $to, $text);

Log::info('SMS sent', [
    'user_id' => auth()->id(),
    'to' => $to,
    'success' => $result['success'],
    'message_id' => $result['id'] ?? null,
]);
```

### 5. Error Handling

Don't expose sensitive information in error messages:

```php
try {
    $result = Bandwidth::sendMessage($from, $to, $text);

    if (!$result['success']) {
        // Log the detailed error
        Log::error('SMS failed', ['error' => $result['error']]);

        // Return generic message to user
        return response()->json(['error' => 'Failed to send message'], 500);
    }
} catch (\Exception $e) {
    Log::error('SMS exception', ['exception' => $e->getMessage()]);
    return response()->json(['error' => 'An error occurred'], 500);
}
```

### 6. Keep Package Updated

Regularly update to the latest version:

```bash
composer update palpalani/laravel-bandwidth-api
```

Enable Dependabot or similar tools to get automatic security updates.

### 7. Use HTTPS for Webhooks

When configuring Bandwidth webhooks, always use HTTPS endpoints:

```php
// Verify webhook signatures
$signature = request()->header('X-Bandwidth-Signature');
// Implement signature verification
```

## Known Security Considerations

### API Credential Storage

This package stores API credentials in Laravel's configuration system. Ensure:

- `.env` file is not committed to version control
- `.env` file has proper file permissions (600 or 640)
- Production servers use secure environment variable management

### Phone Number Handling

Phone numbers are PII (Personally Identifiable Information):

- Encrypt phone numbers in database storage
- Implement proper access controls
- Comply with GDPR, CCPA, and other privacy regulations
- Consider data retention policies

### Message Content

SMS/MMS content may contain sensitive information:

- Don't log full message content
- Implement content filtering for sensitive data
- Consider end-to-end encryption for sensitive communications
- Follow TCPA and other messaging regulations

## Security Features

This package includes:

- ✅ **Structured error handling** - Prevents information leakage
- ✅ **Type-safe API** - Reduces injection risks
- ✅ **No eval or dynamic code execution** - Prevents code injection
- ✅ **Validated inputs** - All inputs type-checked
- ✅ **Dependency scanning** - Automated via Dependabot
- ✅ **CodeQL analysis** - Automated security scanning
- ✅ **Regular updates** - Active maintenance

## Vulnerability Disclosure Policy

We follow **coordinated vulnerability disclosure**:

1. **Private Report** - Report privately to maintainers
2. **Assessment** - We assess and develop fix
3. **Patch Release** - We release security patch
4. **Advisory** - We publish security advisory
5. **Public Disclosure** - Full details disclosed after fix is available

**Embargo Period:** We request a 90-day embargo before public disclosure to allow users time to update.

## Security Hall of Fame

We recognize security researchers who responsibly disclose vulnerabilities:

<!-- Security researchers will be listed here -->

*No vulnerabilities have been reported yet.*

## Bug Bounty Program

We currently do not offer a bug bounty program. However, we deeply appreciate security researchers who help improve the security of this package and will credit all valid reports in our security advisories.

## Contact

- **Security Issues:** palani.p@gmail.com
- **General Questions:** [GitHub Discussions](https://github.com/palpalani/laravel-bandwidth-api/discussions)
- **GitHub Security Advisory:** [Report a vulnerability](https://github.com/palpalani/laravel-bandwidth-api/security/advisories)

## Additional Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [Bandwidth Security Documentation](https://www.bandwidth.com/security/)
- [TCPA Compliance](https://www.fcc.gov/document/telephone-consumer-protection-act-1991)

---

**Last Updated:** 2025-01-09

Thank you for helping keep `laravel-bandwidth-api` and its users safe! 🔒
