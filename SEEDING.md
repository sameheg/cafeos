# Database Seeding Guide

## Overview
- TBD

## Prerequisites
- TBD

## Setup
- TBD

## Usage
- TBD

## References
- TBD


## Purpose
Seeds initial data required for the platform to function.

## Seeded Data
- **Roles & Permissions**
  - Super Admin, Owner, Manager, Cashier, Waiter, Chef.
- **Super Admin Tenant**
  - Default system tenant for managing the platform.
- **Sample Tenant**
  - Example cafe with demo users and sample POS items.
- **Sample Products**
  - Espresso, Latte, Cappuccino, Sandwich, Salad.
- **Default Settings**
  - Tax rates, loyalty configuration, feature flags.

## Command
```bash
php artisan migrate:fresh --seed
```

This will create demo tenants, users, and products.
