# laravel-app-version

[![release](https://img.shields.io/github/release/jdenoc/laravel-app-version.svg?style=flat-square)](https://github.com/jdenoc/laravel-app-version/releases/latest)
[![Github Actions](https://img.shields.io/github/workflow/status/jdenoc/laravel-app-version/Laravel%20artisan%20app:version?style=flat-square)](https://github.com/jdenoc/laravel-app-version/actions)
[![License](https://img.shields.io/github/license/jdenoc/laravel-app-version?style=flat-square)](LICENSE)

## Installation

You can install the package via composer:

```bash
composer require jdenoc/laravel-app-version
```

## Usage

```bash
# Get app version
php artisan app:version

# Set app version
php artisan app:version x.y.z
```

### Testing

```bash
vendor/bin/phpunit
```

### PHP Version Support
- 7.2
- 7.3
- 7.4

### FAQ

>**Q:** _I've tried setting the app version, but it doesn't seem to be changing?_
>
>**A:** _You're laravel config is likely cached. Run `artisan config:clear` to clear the cache, then try again._