# Database Seeding Guide

## Overview
- This section outlines the primary goals and scope of Seeding.

## Prerequisites
- Familiarity with basic Seeding concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Seeding in your environment.

## Usage
- Instructions and examples for applying Seeding in day-to-day operations.

## References
- Additional resources and documentation about Seeding for further learning.


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
