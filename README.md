# EliteSaaS Core Infrastructure

This repository provides the multitenant foundation for the EliteSaaS platform built on **Laravel 12** with [spatie/laravel-multitenancy](https://github.com/spatie/laravel-multitenancy).

## Installation

Add the packages to `composer.json`:

```json
{
    "require": {
        "laravel/framework": "^12.0",
        "spatie/laravel-multitenancy": "^3.8"
    }
}
```

Install dependencies and publish vendor assets:

```bash
composer install
php artisan vendor:publish --provider="Spatie\\Multitenancy\\MultitenancyServiceProvider" --tag="config"
php artisan vendor:publish --provider="Spatie\\Multitenancy\\MultitenancyServiceProvider" --tag="migrations"
php artisan migrate
```

## Tenant Initialisation

Create a new tenant and run its migrations:

```bash
php artisan tenant:init {name} {domain}
```

## Testing

Run the test suite:

```bash
./vendor/bin/phpunit
```

## CI/CD

* `.github/workflows/ci.yml` runs coding standards and the test suite on every push and pull request.
* `.github/workflows/deploy.yml` deploys the application to production when pushing to `main`.

