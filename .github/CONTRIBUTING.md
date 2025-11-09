# Contributing to laravel-bandwidth-api

First off, thank you for considering contributing to laravel-bandwidth-api! 🎉

Contributions are **welcome** and will be fully **credited**. We value your time and effort in helping make this package better.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Pull Request Process](#pull-request-process)
- [Coding Standards](#coding-standards)
- [Testing Guidelines](#testing-guidelines)
- [Commit Message Guidelines](#commit-message-guidelines)

## Code of Conduct

This project and everyone participating in it is governed by our commitment to fostering an open and welcoming environment. Please be respectful, considerate, and professional in all interactions.

### Our Standards

- **Be respectful** - Treat everyone with respect and consideration
- **Be constructive** - Provide constructive feedback and criticism
- **Be patient** - Maintainers are volunteers giving their free time
- **Be collaborative** - Work together toward the best solution

## How Can I Contribute?

### 🐛 Reporting Bugs

Before submitting a bug report:

1. **Check existing issues** - Your bug may already be reported
2. **Test with the latest version** - The bug might already be fixed
3. **Verify it's reproducible** - Ensure it's not a one-time occurrence
4. **Check the documentation** - Make sure it's not expected behavior

When submitting a bug report, use our [Bug Report template](.github/ISSUE_TEMPLATE/bug_report.yml) and provide:

- Clear description of the issue
- Steps to reproduce
- Expected vs actual behavior
- Code samples
- Environment details (PHP, Laravel, package versions)
- Error messages and stack traces

### 💡 Suggesting Features

Before suggesting a feature:

1. **Search existing issues and discussions** - It may already be proposed
2. **Check the roadmap** - It might already be planned
3. **Consider the scope** - Does it fit the package's purpose?
4. **Think about other users** - Will it benefit the broader community?

Use our [Feature Request template](.github/ISSUE_TEMPLATE/feature_request.yml) to propose new features.

### 📖 Improving Documentation

Documentation improvements are always welcome! This includes:

- Fixing typos or clarifying existing documentation
- Adding examples or use cases
- Improving the README
- Writing tutorials or guides
- Adding code comments

### 🔧 Contributing Code

We welcome code contributions! Here's how to get started:

## Development Setup

### Prerequisites

- PHP 8.3 or higher
- Composer
- Git
- A GitHub account

### Setup Steps

1. **Fork the repository**

   Click the "Fork" button on GitHub to create your own copy.

2. **Clone your fork**

   ```bash
   git clone https://github.com/YOUR-USERNAME/laravel-bandwidth-api.git
   cd laravel-bandwidth-api
   ```

3. **Install dependencies**

   ```bash
   composer install
   ```

4. **Create a branch**

   ```bash
   git checkout -b feature/your-feature-name
   # or
   git checkout -b fix/your-bug-fix
   ```

5. **Set up your environment**

   Copy `.env.example` if needed and configure test credentials (optional).

## Pull Request Process

### Before Submitting

1. **Ensure tests pass**

   ```bash
   composer test
   ```

2. **Run code style fixer**

   ```bash
   composer format
   ```

3. **Run static analysis**

   ```bash
   composer analyse
   ```

4. **Update documentation**

   - Update README.md if adding features
   - Add/update PHPDoc blocks
   - Update CHANGELOG.md (if not automated)

### Submitting Your PR

1. **Push to your fork**

   ```bash
   git push origin feature/your-feature-name
   ```

2. **Create a Pull Request**

   - Go to the original repository
   - Click "New Pull Request"
   - Select your fork and branch
   - Fill out the PR template

3. **PR Title Convention**

   Use conventional commit style:

   - `feat: Add MMS media support`
   - `fix: Correct response handling in sendMessage`
   - `docs: Update installation instructions`
   - `refactor: Simplify error handling`
   - `test: Add coverage for voice API`
   - `chore: Update dependencies`

4. **PR Description**

   Include:
   - What changed and why
   - Related issue numbers (`Fixes #123`, `Closes #456`)
   - Breaking changes (if any)
   - How to test the changes

### PR Review Process

1. **Automated checks** - CI must pass (tests, code style, static analysis)
2. **Code review** - Maintainers will review and provide feedback
3. **Revisions** - Make requested changes and push updates
4. **Approval** - Once approved, your PR will be merged
5. **Credit** - You'll be added to the contributors list!

## Coding Standards

We follow modern Laravel and PHP best practices:

### PHP Standards

- **PSR-12** - PHP coding standard
- **Strict types** - Use `declare(strict_types=1)`
- **Type hints** - Use typed properties and return types
- **Nullable syntax** - Use `?string` instead of `string|null`

### Laravel Conventions

- **Naming** - Follow Laravel naming conventions
  - camelCase for methods and variables
  - PascalCase for classes
  - kebab-case for routes and config files
  - snake_case for config keys

- **Facades** - Use dependency injection when possible, facades when appropriate

- **Config** - Add new configs to `config/bandwidth.php`, not new files

### Code Style

We use **Laravel Pint** for automatic code formatting:

```bash
composer format
```

Key style points:

- 4 spaces for indentation
- No trailing whitespace
- Unix line endings (LF)
- Blank line at end of files
- Import all classes at the top
- One statement per line

### Documentation

- Add PHPDoc blocks for all public methods
- Include `@param`, `@return`, and `@throws` tags
- Use type hints in docblocks for arrays: `@param array<int, string> $items`
- Write clear, concise descriptions

Example:

```php
/**
 * Send an SMS message via Bandwidth API.
 *
 * @param string $from The sender's phone number (E.164 format)
 * @param array<int, string> $to Array of recipient phone numbers
 * @param string $text The message text content
 * @param string|null $tag Optional tag for organizing messages
 * @return array{success: bool, message: string, id?: string, data?: object, error?: string}
 */
public function sendMessage(string $from, array $to, string $text, string|null $tag = null): array
{
    // Implementation
}
```

## Testing Guidelines

### Writing Tests

We use **Pest** for testing. All new features must include tests.

1. **Test file location**

   Place tests in `tests/` directory, mirroring the `src/` structure.

2. **Test naming**

   Use descriptive test names:

   ```php
   it('sends SMS message successfully')
   it('handles API errors gracefully')
   it('validates phone number format')
   ```

3. **Test coverage**

   - Aim for 70%+ code coverage
   - Test happy paths
   - Test error cases
   - Test edge cases

4. **Run tests**

   ```bash
   # Run all tests
   composer test

   # Run with coverage
   vendor/bin/pest --coverage

   # Run specific test
   vendor/bin/pest --filter sendMessage
   ```

### Test Structure

Follow the Arrange-Act-Assert pattern:

```php
it('sends message successfully', function () {
    // Arrange - Set up test data
    $from = '+1234567890';
    $to = ['+0987654321'];
    $text = 'Test message';

    // Act - Execute the code
    $result = Bandwidth::sendMessage($from, $to, $text);

    // Assert - Verify the outcome
    expect($result['success'])->toBeTrue();
    expect($result['id'])->not->toBeNull();
});
```

## Commit Message Guidelines

Use **Conventional Commits** format:

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat` - New feature
- `fix` - Bug fix
- `docs` - Documentation changes
- `style` - Code style changes (formatting, etc.)
- `refactor` - Code refactoring
- `test` - Adding or updating tests
- `chore` - Maintenance tasks

### Examples

```bash
feat(messaging): add support for MMS media attachments

- Add media parameter to sendMessage method
- Update MessageRequest to handle media URLs
- Add validation for media URLs

Closes #123
```

```bash
fix(error-handling): correct response structure for API errors

Previously, errors were not properly formatted in the response array.
This fix ensures all errors follow the documented structure.

Fixes #456
```

### Commit Best Practices

- Use imperative mood ("Add feature" not "Added feature")
- Keep subject line under 72 characters
- Separate subject from body with blank line
- Reference issues in footer
- Explain **what** and **why**, not **how**

## Release Process

Maintainers handle releases. The process:

1. Update version in `composer.json`
2. Update `CHANGELOG.md` (automated on release)
3. Create GitHub Release with tag
4. Package published to Packagist automatically

## Questions?

- 💬 [Ask in Discussions](https://github.com/palpalani/laravel-bandwidth-api/discussions)
- 📧 Email: palani.p@gmail.com
- 📚 [Read the Documentation](https://github.com/palpalani/laravel-bandwidth-api#readme)

## Recognition

Contributors are automatically added to the [Contributors list](https://github.com/palpalani/laravel-bandwidth-api/graphs/contributors) and credited in release notes.

---

**Thank you for contributing! 🙏**

Your contributions help make this package better for everyone. Whether it's a typo fix or a major feature, every contribution is valued and appreciated.

**Happy coding!** 🚀
