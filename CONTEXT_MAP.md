# Context Map — Anchor for Codex & Contributors

## Modules (nwidart)
- Core: Tenancy, RBAC, Feature Flags, EventBus, Health
- SuperAdmin: per‑tenant module lifecycle, impersonation, audit
- Billing: Cashier + plans + webhooks + enforcement
- POS: checkout, taxes/discounts, printing, shifts, refunds, offline
- KDS: stations/routing, state machine, expo, realtime
- Inventory: UOM/recipes/BOM, COGS, transfers, stocktake, waste
- Procurement: RFQ→PO→GRN/Invoice, approvals, supplier prices
- CRM, Loyalty, QR Ordering, Table Reservations, Floor Plan, Notifications
- Reports: X/Z, Daily Sales, Top SKUs, Discounts/Void
- Dashboard: executive KPIs + system health

## Hotpaths
- POS checkout → events → KDS routing
- Inventory BOM deduct + COGS
- Billing plan gating (tenant_modules)

## Policies & Traits
- `TenantModel` + `BelongsToTenant`, Spatie Policies
- Event naming: `context.entity.action`
