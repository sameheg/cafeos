# EliteSaaS Core

This repository provides the core infrastructure for the EliteSaaS multi-tenant platform built on Laravel 12.

## Setup

1. Clone the repository and install dependencies:
   ```bash
   composer install
   ```
2. Copy `env.example` to `.env` and adjust settings.
3. Generate the application key:
   ```bash
   php artisan key:generate
   ```
4. Publish the Spatie multitenancy configuration and migrations:
   ```bash
   php artisan vendor:publish --provider="Spatie\\Multitenancy\\MultitenancyServiceProvider" --tag="multitenancy-config"
   php artisan vendor:publish --provider="Spatie\\Multitenancy\\MultitenancyServiceProvider" --tag="migrations"
   ```
5. Run database migrations for the landlord database:
   ```bash
   php artisan migrate
   ```

## Provisioning Tenants

Use the `tenant:init` command to create a tenant, provision its database and run tenant migrations:

```bash
php artisan tenant:init {name} {domain}
```

## Testing

Run the feature suite to ensure tenant isolation and database switching:
```bash
php artisan test
```

## CI/CD

- `.github/workflows/ci.yml` runs linting and the test suite for every push and pull request.
- `.github/workflows/deploy.yml` performs migrations, caches configuration and triggers deployment on pushes to `main`.

## License

The EliteSaaS core is open-sourced software licensed under the MIT license.
