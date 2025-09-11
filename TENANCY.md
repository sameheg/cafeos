# Multi-Tenancy Migration Guide

## Strategy
- Each tenant has isolated DB/schema.  
- Migrations run per tenant using tenancy package.  

## Commands
```bash
php artisan tenants:migrate
php artisan tenants:rollback
```

## Upgrades
- Always test migrations on staging tenants first.  
- Apply migrations gradually with health checks.  

## Rollback
- Rollback only the affected tenant schema if error occurs.  
