# Multi-Tenancy Migration Guide

## Overview
- This section outlines the primary goals and scope of Tenancy.

## Prerequisites
- Familiarity with basic Tenancy concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Tenancy in your environment.

## Usage
- Instructions and examples for applying Tenancy in day-to-day operations.

## References
- Additional resources and documentation about Tenancy for further learning.


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

## Related Docs
- [README.md](README.md)
- [MASTER_INDEX.md](MASTER_INDEX.md)


## Changelog
- Added Last Updated metadata

Last Updated: 2025-09-11 by ChatGPT
