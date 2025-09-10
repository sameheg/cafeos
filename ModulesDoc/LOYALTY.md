# Loyalty Module

## Overview
Coupons, points, rewards, gamification.

## Features
- Core functional features of Loyalty.
- Integration with other CafeOS modules.
- i18n/RTL and multi-currency ready.

## Dependencies
- Depends on: Core (tenancy, RBAC, EventBus).
- May require: Billing, Inventory, Notifications.

## Workflows
```mermaid
flowchart LR
  A[Loyalty] --> B[EventBus]
  B --> C[Reports]
```
- Example workflow for Loyalty.

## UI/UX
- Interfaces: dashboards, CRUD screens, forms.
- POS/KDS integration if applicable.
- Mobile-first responsive layouts.

## Missing Items
- [ ] Add automated tests for Loyalty.
- [ ] Add REST/GraphQL endpoints.
- [ ] Add Blade components with namespace.
- [ ] Production-grade validations.

## Future Enhancements
- Extend Loyalty with AI-driven analytics and marketplace hooks.
