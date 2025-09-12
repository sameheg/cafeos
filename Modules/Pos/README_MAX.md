# POS — ENTERPRISE MAX (No-Gaps)

## Added on top of ENTERPRISE
- **RBAC Policies**: fine-grained permissions (pay/discount/refund/update).
- **Idempotency middleware** for payment/refund/discount endpoints.
- **TotalsCalculator** service: recalculates full order totals.
- **Billing/Loyalty/Inventory** services (hooks).
- **Reservations Guard** before starting an order on a reserved table.
- **KDS Broadcasting**: order status & item kitchen updates via websockets.
- **Settings** per-tenant: default tax/service/currency.
- **Customer link on orders**.
- **Strong Audit** (listener to write audits for sensitive domain events).
- **Advanced Reports endpoints** (extend as needed).
- **Demo Seeder** for quick bootstrapping.

> جاهز للربط مع Modules: Inventory, Billing, CRM, Loyalty, Reservations, Notifications, Reports, KDS.
