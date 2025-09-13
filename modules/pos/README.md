# POS Module

The **POS** module provides point‑of‑sale capabilities for CafeOS. It is delivered as a Laravel module and can be enabled within a larger SaaS deployment.

## Installation

1. Require the module via Composer in the host application:
   ```bash
   composer require saasykit/pos
   ```
2. Publish configuration and assets:
   ```bash
   php artisan vendor:publish --tag=pos-config
   php artisan vendor:publish --tag=pos-assets
   ```
3. Run the migrations and seeders:
   ```bash
   php artisan migrate --path=modules/pos/database/migrations
   php artisan db:seed --class=Modules\\Pos\\Database\\Seeders\\PosDatabaseSeeder
   ```
4. Compile the frontend assets if necessary:
   ```bash
   npm install && npm run build
   ```

## Multi‑Tenancy Setup

The module is designed to work in a multi‑tenant environment:

1. Ensure the tenant package used by your application is installed and configured.
2. Run POS migrations for each tenant:
   ```bash
   php artisan tenants:migrate --module=pos
   ```
3. Seed tenant‑specific data as needed:
   ```bash
   php artisan tenants:seed --class=Modules\\Pos\\Database\\Seeders\\PosDatabaseSeeder
   ```
4. Enable the POS module per tenant through your tenancy management UI or using application logic.

## Extensibility

- **Service Providers:** Register your own service provider in `Modules/Pos/Providers` to override bindings or add functionality.
- **Views & Assets:** Publish the views with `php artisan vendor:publish --tag=pos-views` and customize them in your application.
- **Events & Listeners:** Hook into POS events (e.g., `SaleCompleted`) to integrate with external systems.
- **API & Routing:** Extend the module’s routes by adding controllers within `Modules/Pos/Http/Controllers` and updating the route files.

## Testing Strategy

| Tool | Purpose |
| ---- | ------- |
| **PHPUnit** | Unit and feature tests located in `tests/` or under `Modules/Pos/Tests`. |
| **Pest** | Offers an expressive BDD style for additional test coverage. |
| **Laravel Dusk** | Browser tests validating end‑to‑end POS workflows. |
| **Accessibility Checks** | Automated via tools such as Axe or Pa11y run inside Dusk tests. |

Run the full suite locally:
```bash
./vendor/bin/pest
php artisan dusk --env=dusk
npm run build && npx pa11y-ci
```

## CI/CD Integration

Integrate the module into your pipeline by:

1. Running `composer install` and `npm ci` on each build.
2. Executing the test matrix:
   - `./vendor/bin/phpunit`
   - `./vendor/bin/pest`
   - `php artisan dusk --env=dusk`
   - `npx pa11y-ci` for accessibility.
3. Building and versioning assets with `npm run build`.
4. Deploying using your preferred strategy (e.g., Docker or Deployer) once tests pass.

This ensures consistent quality and reliability across all environments.
