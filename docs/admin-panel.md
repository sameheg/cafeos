# EliteSaaS Admin Panel

This document outlines the structure of the Filament based admin panel. It
serves as a reference for developers extending or integrating with the panel.

## Packages

Ensure the following packages are installed:

```bash
composer require filament/filament:^3.0 livewire/livewire:^3.0 tenancy/tenancy spatie/laravel-permission laravel/pennant
```

## Service Provider

The panel is registered via `App\Providers\Filament\AdminPanelProvider` which
auto-discovers resources, pages and widgets from the application and modules.

## Structure

```
app/
├── Filament/
│   ├── Pages/
│   │   └── Dashboard.php
│   └── Widgets/
│       ├── StatsOverview.php
│       └── TenantStats.php
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php
Modules/Core/
└── app/
    ├── Filament/
    │   └── Resources/
    │       ├── TenantResource.php
    │       └── UserResource.php
    └── Models/
        └── Tenant.php
```

Additional resources for other modules can follow the same convention under
`Modules/<Module>/app/Filament`.

## Migrations

The Core module includes a migration for the `tenants` table located at
`Modules/Core/database/migrations`.

## Running

After installing packages and publishing assets run:

```bash
php artisan migrate
npm run build
```

You can access the panel at `/admin`.
