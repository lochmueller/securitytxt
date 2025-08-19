# TYPO3 Extension: security.txt Integration

This TYPO3 extension provides support for the [security.txt standard](https://securitytxt.org/),
which defines a standard way for security researchers to report security vulnerabilities.

By adding a `/.well-known/security.txt` file to your TYPO3 installation, this extension
helps your project communicate a clear and standardized security contact policy.

## Features

- Automatically serves a `/.well-known/security.txt` file.
- Support multi tenant installations.
- Fully compliant with the [RFC 9116 specification](https://www.rfc-editor.org/rfc/rfc9116).
- Easy configuration through TYPO3 backend.
- Supports multiple contact methods (email, URL, etc.).

## Installation

Install the extension via [Composer](https://getcomposer.org/):

```bash
composer require lochmueller/securitytxt
```

## More information

- https://www.rfc-editor.org/rfc/rfc9116
- https://securitytxt.org/
- https://de.wikipedia.org/wiki/Security.txt

## Open @todo

- Add to https://securitytxt.org/projects
