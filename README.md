# laravel-app-version
[![GitHub release](https://img.shields.io/github/release/jdenoc/laravel-app-version.svg)](https://github.com/jdenoc/money-tracker/releases/latest)
![Github Actions](https://github.com/jdenoc/laravel-app-version/workflows/Laravel%20artisan%20app:version/badge.svg?branch=main)

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
- 7.0
- 7.1
- 7.2
- 7.3
- 7.4
- 8.0

### FAQ

>**Q:** _I've tried setting the app version, but it doesn't seem to be changing?_
>
>**A:** _You're laravel config is likely cached. Run `artisan config:clear` to clear the cache, then try again._