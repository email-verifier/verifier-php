# Email Verifier PHP Library

A PHP library for validating emails using the VerifyRight API. Checks for non-existent emails, invalid domains, and disposable email addresses.

## Installation

Install via Composer:

```bash
composer require email-verifier/verifier-php
```

## Usage

Basic usage:

```php
use EmailVerifier\EmailVerifier;

// Initialize with your API token
$verifier = new EmailVerifier('YOUR_ACCESS_TOKEN');

// Simple verification (returns true/false)
try {
    $isValid = $verifier->verifyEmail('test@example.com');
} catch (InvalidArgumentException $e) {
    // Handle invalid email format
    echo "Invalid email format: " . $e->getMessage();
} catch (RuntimeException $e) {
    // Handle API errors
    echo "API error: " . $e->getMessage();
}

// Get detailed verification results
try {
    $details = $verifier->verifyEmail('test@example.com', true);
    /*
    Returns array with:
    {
        "status": "valid",
        "domain": "example.com",
        "is_disposable": false,
        "is_role_account": false
    }
    */
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Features

- Email format validation
- Domain existence check
- Disposable email detection
- Role account detection
- Detailed verification results
- Modern PHP 7.4+ support
- Exception handling
- PSR-4 autoloading

## Requirements

- PHP 7.4 or higher
- curl extension
- json extension

## License

MIT License
