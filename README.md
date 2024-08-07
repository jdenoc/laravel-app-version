# laravel-app-version

[![release](https://img.shields.io/github/release/jdenoc/laravel-app-version.svg?style=flat-square)](https://github.com/jdenoc/laravel-app-version/releases/latest)
[![Github Actions](https://img.shields.io/github/actions/workflow/status/jdenoc/laravel-app-version/tests.yml?style=flat-square)](https://github.com/jdenoc/laravel-app-version/actions)
[![License](https://img.shields.io/github/license/jdenoc/laravel-app-version?style=flat-square)](LICENSE)

## Installation

You can install the package via composer:

```bash
composer require jdenoc/laravel-app-version
```

## Usage

Get app version
```bash
php artisan app:version
```

Set app version
```bash
php artisan app:version x.y.z
```

### Testing

```bash
vendor/bin/phpunit
```

### PHP Version Support
- 8.2

### Laravel PHP Version
- Laravel 11.x
- Laravel 10.x
  - Use version [4.0.1](https://github.com/jdenoc/laravel-app-version/tree/4.0.1)
- Laravel 9.x
  - Use version [3.0.0](https://github.com/jdenoc/laravel-app-version/tree/3.0.0)
- Laravel 8.x
  - Use version [2.0.0](https://github.com/jdenoc/laravel-app-version/tree/2.0.0)
- Laravel 7.x
  - Use version [1.1.1](https://github.com/jdenoc/laravel-app-version/tree/1.1.1)
- Laravel 6.x
  - Use version [1.0.2](https://github.com/jdenoc/laravel-app-version/tree/1.0.2)

### FAQ

>**Q:** _I've tried setting the app version, but it doesn't seem to be changing?_
>
>**A:** _You're laravel config is likely cached. Run `artisan config:clear` to clear the cache, then try again._