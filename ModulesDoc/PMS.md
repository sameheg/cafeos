# PMS Module

## Overview
Hotel PMS integration (rooms, guests).

## Features
- Core functional features of PMS.
- Integration with other CafeOS modules.
- i18n/RTL and multi-currency ready.

## Dependencies
- Depends on: Core (tenancy, RBAC, EventBus).
- May require: Billing, Inventory, Notifications.

## Workflows
```mermaid
flowchart LR
  A[PMS] --> B[EventBus]
  B --> C[Reports]
```
- Example workflow for PMS.

## UI/UX
- Interfaces: dashboards, CRUD screens, forms.
- POS/KDS integration if applicable.
- Mobile-first responsive layouts.

## Missing Items
- [ ] Add automated tests for PMS.
- [ ] Add REST/GraphQL endpoints.
- [ ] Add Blade components with namespace.
- [ ] Production-grade validations.

## Future Enhancements
- Extend PMS with AI-driven analytics and marketplace hooks.
