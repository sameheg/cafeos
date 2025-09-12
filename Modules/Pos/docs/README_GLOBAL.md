# POS — GLOBAL (Advanced Capabilities)

## What’s new
- **Delivery/Takeaway**: order_type + delivery_status + driver assignment
- **Promotions Engine**: promotions/rules/redemptions (+ apply by code)
- **Multi-branch Ready**: branch_id on orders
- **Hardware Stubs**: printers table + print receipt & open drawer APIs
- **Observability**: /health & /metrics
- **Compliance placeholders**: tax_id + invoice_number
- **Advanced Reports**: P&L + occupancy

## Key APIs
- Delivery: POST `/api/v1/pos/order/{order}/delivery/assign` + PATCH `/delivery/{status}`
- Promotions: GET `/api/v1/pos/promotions`, POST `/api/v1/pos/order/{order}/promotions/apply`
- Hardware: POST `/api/v1/pos/order/{order}/print/{printer}`, POST `/api/v1/pos/drawer/{printer}/open`
- Observability: GET `/api/v1/pos/health`, GET `/api/v1/pos/metrics`
- Reports: GET `/api/v1/pos/reports/pnl`, GET `/api/v1/pos/reports/occupancy`

> كل ده قابل للتوصيل مع الموديولات اللي عندك (Inventory/Billing/CRM/Loyalty/Reservations/KDS/Reports) عبر الهوكس والـevents الموجودة.
