# AGENTS.md

> **Purpose:** This document defines each Agent (bot/microservice) in the **Codex SaaS POS** project, outlining responsibilities, APIs, events, dependencies, operational metrics, and runbooks. The goal is to operate the system fully automated (Codegen + CI/CD) with minimal human intervention.

---

## 0) Quick Map (TL;DR)

* **Orchestrator Agent**: Global coordinator, receives tasks and triggers other agents.
* **Catalog Agent**: Manages products, categories, units of measure, recipes.
* **Inventory Agent**: Stock levels, movements, alerts, reorder points.
* **POS Agent**: Orders, payments, receipts, shift closures (Z/X Reports).
* **KDS Agent**: Kitchen Display System, tickets, prep times.
* **CRM Agent**: Customers, loyalty, coupons, messaging.
* **Pricing & Promotions Agent**: Dynamic pricing, Happy Hour, rules.
* **Reporting Agent**: Dashboards, exports, KPIs.
* **Sync & Integrations Agent**: Channels, gateways, webhooks.
* **Compliance Agent**: E-invoice, QR, legal archiving.

> **Naming convention:** `agent-<domain>` (e.g., `agent-inventory`). Main branch: `main`; feature branches: `feat/<agent>/<topic>`.

---

## 1) Orchestrator Agent

**Role:** Accepts orchestration plans from Codex/CLI/GitHub Actions, schedules tasks, coordinates other agents.

* **Triggers:**

  * Push to `main`
  * PR open/merge
  * Manual command `/orchestrate`
* **Inputs:** YAML/JSON plans, e.g.:

```yaml
run:
  - agent: agent-catalog
    task: seed-initial-data
    args:
      business_id: 1
  - agent: agent-pricing
    task: apply-happy-hour
    args:
      store_id: 3
      from: "16:00"
      to: "18:00"
```

* **Outputs:** Structured logs + Domain events.
* **Internal API:**

  * `POST /orchestrate` execute plan
  * `GET /status/:runId` monitor status
* **Events:** `plan.started`, `plan.step.succeeded`, `plan.failed`
* **Metrics:** `orchestrator.plan_latency_ms`, `orchestrator.step_success_ratio`
* **SLA:** 99% success for plans ≤10 steps within 5 minutes.
* **Runbook:** Failed steps retried 3x with backoff; persistent failure raises incident.

---

## 2) Catalog Agent

**Role:** Catalog domain (products, categories, UOM, recipes).

* **Core tasks:**

  * CRUD products & categories
  * Manage UOM and conversions
  * Recipes/BoM linked to inventory
* **API:**

  * `POST /catalog/products`
  * `GET /catalog/products?search=`
  * `POST /catalog/recipes/sync`
* **Events:** `product.created`, `product.updated`, `recipe.changed`
* **Integrations:** Database tables `products`, `uom`, `recipes`; coordinates with Inventory Agent.
* **Metrics:** `catalog.products_count`, `catalog.recipe_sync_time_ms`
* **SLA:** Response ≤ 250ms, UOM conversions 100% accurate.
* **Data Example:**

```json
{
  "sku": "ESP-001",
  "name": "Espresso Single",
  "uom": "cup",
  "price": 35.00,
  "recipe": [
    {"ingredient": "coffee_beans", "qty": 8, "uom": "gram"},
    {"ingredient": "water", "qty": 30, "uom": "ml"}
  ]
}
```

---

## 3) Inventory Agent

**Role:** Manage stock, movements, reorder alerts, costing.

* **Tasks:**

  * Record in/out/transfers
  * Reorder points + alerts
  * Raw material costing (FIFO/Avg)
* **API:**

  * `POST /inventory/movements`
  * `GET /inventory/levels?store_id=`
  * `POST /inventory/reorder/calc`
* **Events:** `stock.below_threshold`, `movement.recorded`
* **Rules:** POS updates automatically deduct stock based on recipe.
* **Metrics:** `inventory.stockout_events`, `inventory.adjustment_rate`
* **SLA:** Stock deduction ≤ 5s after order.
* **Movement Example:**

```json
{
  "item": "coffee_beans",
  "change": -8,
  "uom": "gram",
  "ref": "order#A123-espresso",
  "store_id": 1
}
```

---

## 4) POS Agent

**Role:** Orders, payments, receipts, shift closures.

* **API:**

  * `POST /pos/orders`
  * `POST /pos/payments`
  * `GET /pos/reports/z`
* **Events:** `order.created`, `order.paid`, `shift.closed`
* **Integrations:** Payment gateways via Sync Agent.
* **Metrics:** `pos.orders_count`, `pos.payment_fail_rate`
* **SLA:** Order processing ≤1s; payment confirmation ≤3s.
* **Invoice Example:**

```json
{
  "order_no": "2025-09-05-000123",
  "items": [
    {"sku": "ESP-001", "qty": 1, "price": 35.00}
  ],
  "subtotal": 35.00,
  "tax": 0.00,
  "total": 35.00,
  "payment": {"method": "card", "status": "captured", "tx": "tx_abc123"}
}
```

---

## 5) KDS Agent (Kitchen Display)

**Role:** Kitchen tickets & prep times.

* **Channels:** WebSocket for live events, REST for queries.
* **Events:** `kds.ticket.created`, `kds.ticket.done`
* **Metrics:** `kds.avg_prep_time`, `kds.queue_length`
* **SLA:** Ticket update ≤1s after order creation.

---

## 6) CRM Agent

**Role:** Customers, loyalty, coupons, messaging.

* **API:**

  * `POST /crm/customers`
  * `POST /crm/coupons/issue`
  * `POST /crm/loyalty/earn`
* **Events:** `customer.created`, `coupon.redeemed`, `loyalty.earned`
* **Metrics:** `crm.repeat_rate`, `crm.coupon_redemption_rate`
* **SLA:** Customer ops ≤300ms.

---

## 7) Pricing & Promotions Agent

**Role:** Dynamic pricing rules, Happy Hour, bundles.

* **Rules:**

  * Formula: `price = base * (1 + margin)`
  * Time-based: `if time in [16:00-18:00] then -20%`
* **API:** `POST /pricing/apply`, `GET /pricing/eval?sku=&time=`
* **Events:** `price.rule.applied`
* **Metrics:** `pricing.rules_count`, `pricing.eval_latency_ms`
* **SLA:** Pricing eval ≤50ms.

---

## 8) Reporting Agent

**Role:** KPIs, dashboards, exports.

* **Store:** Materialized views + nightly jobs.
* **API:**

    * `GET /reports/kpi?range=7d`
    * `POST /reports/export`
    * `GET /analytics/realtime` – SSE stream of live sales & forecasts
* **Services:** `ForecastService` combines sales and inventory data
* **Metrics:** `report.jobs_duration_ms`, `report.queue_backlog`
* **SLA:** Daily report ≤5m.

---

## 9) Sync & Integrations Agent

**Role:** Payment gateways, webhooks, channels.

* **Connectors:** Stripe, PayPal, MyFatoorah, Paystack, Razorpay, Dropbox, S3.
* **Webhooks:** `POST /sync/webhooks/:provider`
* **Events:** `payment.captured`, `refund.issued`
* **Retries:** Exponential backoff + DLQ.
* **SLA:** Sync latency ≤2s avg.

---

## 10) Compliance Agent

**Role:** E-invoicing, QR, legal archiving.

* **API:** `POST /compliance/einvoice`, `GET /compliance/audit/:docId`
* **Output:** XML/JSON per jurisdiction + signed PDF.
* **SLA:** Invoice generation ≤2s.

---

## 11) Event Bus

* **Transport:** Redis Streams / RabbitMQ / Kafka.
* **Event Format:**

```json
{
  "id": "evt_169390123",
  "type": "order.created",
  "source": "agent-pos",
  "time": "2025-09-05T12:34:56Z",
  "data": {}
}
```

* **Policies:** Retention 7d, idempotency key, DLQ + replay.

---

## 12) Security & Compliance

* **Secrets:** Vault/Secrets Manager (not in .env committed).
* **Auth:** OAuth2/JWT, RBAC.
* **Compliance:** Audit logs immutable, encryption at-rest/in-transit.

---

## 13) Observability

* **Logs:** JSON unified, Correlation-Id.
* **Metrics:** Prometheus/OpenTelemetry.
* **Tracing:** Distributed traces via OpenTelemetry → Jaeger.

---

## 14) CI/CD

* **Trigger:** On push/PR.
* **Stages:** Lint → Test → Build → Package → Deploy → Smoke.
* **Artifacts:** Docker image `registry/agent-<name>:<sha>`.
* **Deployment:** Blue/Green or Canary for critical agents.

---

## 15) ENV Variables

Example (`.env.example` per agent):

```env
APP_ENV=production
APP_KEY=base64:...
DB_HOST=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
QUEUE_CONNECTION=redis
BROADCAST_DRIVER=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
STRIPE_KEY=...
MYFATOORAH_API_KEY=...
```

---

## 16) Failure Runbooks

* **Payment failure:** Check provider, retry via DLQ, set status pending, notify user.
* **Unexpected stockout:** Freeze SKUs, alert manager, suggest substitutes.
* **KDS delay:** Check WebSocket/Bus, restart consumer, fallback to polling.

---

## 17) KPIs

* Payment fail rate <1%
* POS order latency ≤1s
* Stock deduction latency ≤5s
* Daily report build ≤5m
* KDS prep time tracked by SKU.

---

## 18) Roles

* **Super Admin:** platform-level config, global pricing, integrations.
* **Ops:** monitoring, upgrades, recovery.
* **Store Manager:** menus, promos, staff.
* **Cashier/Kitchen:** daily ops via POS/KDS.

---

## 19) Code & Branching

* **Lint:** PHP-CS-Fixer, ESLint
* **Tests:** PHPUnit, Pest, Playwright
* **Branches:**

  * `main` stable
  * `release/*`
  * `feat/<agent>/<topic>`
  * `fix/<agent>/<bug>`

---

## 20) Onboarding

1. Clone repo.
2. `cp .env.example .env` + configure.
3. `composer install && npm install && npm run build`.
4. `php artisan migrate --seed`.
5. Run agents locally (Sail/Docker Compose).

---

## 21) Orchestrator Example

```yaml
run:
  - agent: agent-reporting
    task: build-daily-views
    args:
      date: "2025-09-05"
  - agent: agent-sync
    task: reconcile-payments
    args:
      provider: "myfatoorah"
      from: "2025-09-04T00:00:00Z"
      to:   "2025-09-05T00:00:00Z"
```

---

## 22) FAQ

* **Do we push vendor/?** No, rely on `composer install` in CI/CD.
* **Do we push Modules/?** Yes (source code only, add .gitkeep if empty).
* **DB per Agent?** Initially shared DB with schemas; can split later.

---

## 23) Templates

**Event Template:**

```json
{
  "id": "evt_<rand>",
  "type": "<domain.event>",
  "source": "agent-<name>",
  "time": "<ISO8601>",
  "data": {},
  "idempotency_key": "<uuid>"
}
```

**Agent Definition Template:**

```yaml
agent: agent-inventory
owner: ops@company.tld
slas:
  availability: "99.9%"
  latency_ms_p95: 300
endpoints:
  - method: POST
    path: /inventory/movements
alerts:
  - name: stockout_spike
    rule: inventory.stockout_events > 5 in 10m
runbook: docs/runbooks/inventory.md
```

---

## 24) POS ↔ KDS Event Flow

* **Events:** `pos.order.created`, `pos.order.completed`
* **Producer:** POS Agent dispatches these events from `OrderService` when orders are created or completed.
* **Consumer:** KDS Agent's `OrderEventConsumer` transforms events into kitchen tickets and broadcasts them via `KdsService`.

---

**Note:** This document is living. Any new Agent or architecture change must be reflected here immediately with updated APIs, events, metrics, and runbooks.
