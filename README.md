# laravel-app-version

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

### FAQ

>**Q:** _I've tried setting the app version, but it doesn't seem to be changing?_
>
>**A:** _You're laravel config is likely cached. Run `artisan config:clear` to clear the cache, then try again._