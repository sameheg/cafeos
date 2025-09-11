# EliteSaaS Core

Modular multi-tenant SaaS foundation built on **Laravel 12** with the [Spatie Multitenancy](https://github.com/spatie/laravel-multitenancy) package.

## Quick start

```bash
composer create-project laravel/laravel:^12
cd laravel
composer require spatie/laravel-multitenancy
php artisan vendor:publish --provider="Spatie\\Multitenancy\\MultitenancyServiceProvider" --tag="multitenancy-config"
php artisan vendor:publish --provider="Spatie\\Multitenancy\\MultitenancyServiceProvider" --tag="migrations"
```

## Publishing configuration

The `TenantServiceProvider` registers tenancy and domain resolution. Update `.env` with tenant DB credentials and run migrations:

```bash
php artisan migrate
```

## Tenant provisioning

Create a tenant and provision its database:

```bash
php artisan tenant:init {name} {domain}
```

## Testing

```bash
composer test
```

## CI/CD

- `.github/workflows/ci.yml` runs tests on every push and pull request.
- `.github/workflows/deploy.yml` deploys on push to `main`.
