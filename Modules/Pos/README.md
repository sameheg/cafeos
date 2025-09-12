# POS Module — FULL

## Features
- Orders lifecycle (existing) + Discounts + Payments + Refunds
- Customers (CRM-ready)
- Reports API (daily sales, top items)
- Filament Resources (Customers), existing Orders widgets

## API Contracts (summary)
- Customers:
  - GET `/api/v1/pos/customers` — list/search
  - POST `/api/v1/pos/customers` — create
- Payments:
  - POST `/api/v1/pos/order/{order}/pay` — {method, amount, meta?}
- Discounts:
  - POST `/api/v1/pos/order/{order}/discount` — {scope, amount?, percent?, code?}
- Refunds:
  - POST `/api/v1/pos/order/{order}/refund` — {amount, reason?, items?}
- Reports:
  - GET `/api/v1/pos/reports/daily?tenant_id=&date=`
  - GET `/api/v1/pos/reports/top-items?tenant_id=`

## Integrations
- Inventory: reverse stock on refund; decrement on item add (hook existing observers)
- Billing: create invoice on `pay`
- CRM: attach `customer_id` on order (extend PosOrder)
- Loyalty/Membership: award points on `paid`
- Reservations: lock table if reserved
- Notifications: emit events on status changes
- Reports: aggregate into central Reports module

## Migrations
Run: `php artisan migrate`

## Docs
OpenAPI: `docs/openapi.json` (import in Postman)