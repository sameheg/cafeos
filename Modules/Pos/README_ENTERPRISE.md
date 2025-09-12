# POS — Enterprise Additions

## What's new
- **Split Bills**: `pos_bills`, `pos_bill_items` + APIs
- **Taxes/Service**: totals on orders (subtotal, tax/service %, amounts, discounts, paid/outstanding, currency)
- **Item Modifiers**: `pos_item_modifiers` + API
- **Kitchen Workflow**: `kitchen_status` for items + API to change it
- **Audit Logs**: `pos_audits` + listing API
- **Offline Sync (stub)**: tokens + push endpoint
- **OpenAPI**: updated contracts in `docs/openapi.json`

## Next steps
- Wire inventory BOM & unit conversions.
- Enforce audit writes across sensitive actions (discounts, voids, refunds).
- Add cashier permissions & role-based access for audits and refunds.
- Implement idempotency keys for offline mutations.
