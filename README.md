# verifier-php
Official PHP Library for verifier.meetchopra.com

# Installation

```git clone https://github.com/email-verifier/verifier-php.git```

or you can copy the `verify.php` file and add it to your project directory.

# Usage
Verifier-php is email library in php for validating non-exsistent, invalid domain, disposable emails. [Know more](https://verifier.meetchopra.com)


Below is the example of how to use the library

```php
require('path/to/verify.php')

verifyEmail("email@example.com", "ACCESS_TOKEN"); # For boolean response
verifyEmail("email@example.com", "ACCESS_TOKEN", true); # For detailed response
```
