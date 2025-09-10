
# GAPS V2 — النواقص الكاملة مرتبة حسب أولويات إطلاق الموديولات
**نسخة تنفيذية**: نفس ترتيب أولويات الإطلاق (P0→P3)، مع قوائم مراجعة (✅ لاحقًا) ونقاط قبول (AC) مختصرة. تشمل هذه النسخة الفجوات العرضية (Cross‑cutting) التي لم تُذكر في V1.

---

## 🔴 Global (عبر المنظومة)

### P0 — لازم قبل أي إطلاق
- [ ] **Tenancy Wiring**: تسجيل `TenancyServiceProvider` + Trait `BelongsToTenant` + `TenantModel` أساسي. **AC:** كل Query معزول تلقائيًا للـ tenant الحالي.
- [ ] **Feature Flags per Tenant**: جدول `tenant_modules` + Middleware يحجب المسارات/الـUI عند التعطيل. **AC:** تينانت A يرى KDS، B لا.
- [ ] **Realtime Stack**: `config/broadcasting.php` + Reverb/Pusher + قنوات خاصة بالـ tenant + Policies. **AC:** حدث POS يظهر على KDS < 200ms.
- [ ] **Queues/Workers**: Horizon أو Worker دائم في Docker/Prod. **AC:** 0 رسائل متراكمة > 2 دقيقة.
- [ ] **RBAC Unification**: مصدر واحد للصلاحيات (Spatie+Teams أو Consolidation) + Seeders. **AC:** لا تعارض مَيچريشن.
- [ ] **CI/CD & Tests**: Github Actions (Pint/PhpStan/Pest/Build) + تغطية مبدئية. **AC:** Pipeline أخضر قبل الدمج.
- [ ] **i18n/RTL**: تغطية مفاتيح AR/EN كاملة + RTL لكل الشاشات الحرجة. **AC:** 0 مفاتيح مفقودة في التقارير.
- [ ] **Security Baseline**: MFA، Rate limiting، Cookies (SameSite/HttpOnly/Secure)، Headers (CSP/HSTS/COOP/CORP). **AC:** فحص أمن أساسي يمر بلا High.

### P1 — خلال أول أسبوعين
- [ ] **Secrets & Supply Chain**: إدارة أسرار خارج `.env` (Vault/SSM) + `composer audit`/npm audit + فحص صور Docker. **AC:** 0 عِلَل حرجة.
- [ ] **Observability**: Sentry + Tracing + Metrics (Prometheus/Grafana). **AC:** Dashboard جاهز (Errors/min, Apdex, p95).
- [ ] **Release Strategy**: Zero‑downtime migrations + Blue/green أو Canary. **AC:** نشر بدون توقف.
- [ ] **Performance & Indexing**: فهارس مركّبة `(tenant_id, status, created_at)` + حظر N+1. **AC:** p95 < 300ms لصفحات CRUD.
- [ ] **Caching Strategy**: Redis object cache + HTTP ETag. **AC:** Hits ≥ 70% للقراءات الشائعة.

### P2 — تحسينات نضج
- [ ] **Data Lifecycle & Privacy**: تصدير/حذف per‑tenant، DPA، Cookies consent. **AC:** طلب حذف يُنفّذ خلال 30 يومًا.
- [ ] **Analytics/Warehouse**: CDC (Outbox/Debezium) إلى ClickHouse/BigQuery. **AC:** لوحات مبيعات يومية بدون ضغط DB الإنتاج.
- [ ] **A11y & Theming**: WCAG 2.1 AA + Theme/Brand per‑tenant. **AC:** تباين ≥ 4.5:1 + معاينات فورية.
- [ ] **API Program**: OpenAPI/Swagger، إصدار v1/v2، Idempotency keys. **AC:** Webhooks/SDKs موثّقة.

---

## P0 — إطلاق المنصة

### Core
- [ ] **(P0)** Tenancy Provider + Trait + Base `TenantModel`.
- [ ] **(P0)** Tenant Switcher آمن + Impersonation.
- [ ] **(P0)** Feature Flags + `tenant_modules`.
- [ ] **(P0)** Sanctum multi‑tenant + Scopes/Rate limits.
- [ ] **(P1)** Health Page (DB/Queue/WS/Scheduler) + Runbooks.
- [ ] **(P1)** Currency/Timezone per tenant.
- **AC:** أي كيان متعدد المستأجرين محمي Scope/Policies تلقائيًا.

### SuperAdmin
- [ ] **(P0)** Module Manager per tenant (Enable/Disable/Version/Health).
- [ ] **(P0)** Impersonation + تدقيق تغييرات (Audit).
- [ ] **(P1)** Config overrides (guarded) + Usage metering.
- **AC:** تشغيل/إيقاف موديول لمستأجر محدد ينعكس فورًا بلا نشر.

### Billing
- [ ] **(P0)** Cashier (Stripe/Paddle) + Subscriptions + Webhooks.
- [ ] **(P0)** Plan enforcement (Feature gating) عبر المنظومة.
- [ ] **(P1)** Dunning/Proration/Upgrade‑Downgrade.
- [ ] **(P1)** Invoices PDF + ضرائب (VAT/KSA) + Portal.
- [ ] **(P2)** Usage metering (Orders/Seats/Locations).
- **AC:** تغيير الخطة يقفل/يفتح ميزات فورًا.

### Pos
- [ ] **(P0)** Multi‑tender + Split/Merge + Order types (Dine/TA/Deliv).
- [ ] **(P0)** Taxes/Service/Fees + Rounding.
- [ ] **(P0)** Discounts/Overrides + Manager PIN + Audit.
- [ ] **(P0)** ESC/POS Printing + Drawer + Kitchen/Receipt mapping.
- [ ] **(P0)** Shifts/Till/XZ + Cash movements.
- [ ] **(P0)** Refund/Void + Reverse inventory + Credit receipt.
- [ ] **(P0)** Offline‑first (IndexedDB, BG Sync, de‑dupe).
- [ ] **(P1)** Devices provisioning + Screen lock (PIN).
- [ ] **(P1)** **e‑Invoice (EG/KSA)** + QR ضريبي + تسلسل فواتير.
- [ ] **(P1)** محاسبي: Xero/QuickBooks export.
- [ ] **(P2)** Scales/PLU + ميزان باركود + Label printing.
- **AC:** بيع أثناء انقطاع الشبكة → Cash only + مزامنة لاحقة بلا ازدواج.

### Inventory
- [ ] **(P0)** UOM & Conversions + Recipes/BOM + Auto‑deduct on sale.
- [ ] **(P0)** Costing (Avg/FIFO/LIFO) + COGS.
- [ ] **(P1)** Transfers/Stocktake/Waste + Alerts (min/max).
- [ ] **(P1)** Supplier linkage + 86‑list.
- [ ] **(P2)** Batch/Lot + Expiry.
- **AC:** بيع كابتشينو يخصم مكونات طبقًا للوصفة.

### Kds
- [ ] **(P0)** Stations/Routes + Groups (Hot/Cold/Bar).
- [ ] **(P0)** State machine (queued→in_progress→ready→expo→served/recall).
- [ ] **(P0)** Private WS channels + Policies.
- [ ] **(P0)** SLA timers/aging + صوتيات.
- [ ] **(P0)** Expo screen (اكتمال الطلب).
- [ ] **(P1)** Device heartbeat/provisioning + Kiosk mode.
- [ ] **(P1)** Resync/diff + Sequencing + Capacity/Load balance.
- [ ] **(P2)** Fallback kitchen printing.
- **AC:** `fire` من POS يظهر على المحطة <200ms وExpo يمنع Serve الناقص.

### Reports
- [ ] **(P0)** Daily Sales, X/Z, Top SKUs, Discounts/Void.
- [ ] **(P1)** COGS/GP%, Stock turns, AOV, Cohorts.
- [ ] **(P2)** Scheduler PDF/CSV + Pre‑aggregations.
- **AC:** تقارير P0 تعمل على بيانات يومية بدون ضغط DB.

### Dashboard
- [ ] **(P0)** KPIs تنفيذية (Net Sales, Orders, AOV, GP% مختصر، KDS Wait).
- [ ] **(P1)** System Health widgets (Workers/WS/Scheduler).
- [ ] **(P1)** Shortcuts (Add product, Open shift, New PO).
- **AC:** اللود ≤ 1s مع كاش.

---

## P1 — تثبيت التشغيل ونمو الإيراد

### Procurement
- [ ] **(P1)** RFQ→PO→GRN/Invoice (3‑way match + Tolerances).
- [ ] **(P1)** Supplier price lists + Lead times.
- [ ] **(P1)** Approvals & thresholds.
- [ ] **(P2)** Spend & supplier performance.
- **AC:** استلام GRN يحدّث المخزون ويغلق PO الجزئي صحيحًا.

### Crm
- [ ] **(P1)** Unified profile + Merge duplicates + Consent.
- [ ] **(P1)** Segments/Cohorts + History.
- [ ] **(P2)** CLV/RFM تقديري.
- **AC:** ربط الطلبات/القنوات بملف عميل واحد.

### Loyalty
- [ ] **(P1)** Rules (earn/redeem) + Ledger + Expiry.
- [ ] **(P1)** Limits/Fraud + POS hooks.
- [ ] **(P2)** Vouchers/Promos integration.
- **AC:** الاسترداد يخصم فورًا ويُسجّل في Audit.

### QrOrdering
- [ ] **(P1)** Table/Zone QR mapping + Anti‑spoofing.
- [ ] **(P1)** Modifiers/Availability + Checkout (Pay at table/counter).
- [ ] **(P2)** Throttling/ETA + PWA offline.
- **AC:** الطلب يظهر على KDS مع الطاولة/المنطقة الصحيحة.

### TableReservations
- [ ] **(P1)** Time slots/Capacity + Holds/Deposits.
- [ ] **(P1)** Waitlist + SMS.
- [ ] **(P2)** iCalendar/ICS export.
- **AC:** Confirm → يفتح Tab في POS تلقائيًا.

### FloorPlanDesigner
- [ ] **(P1)** Drag&Drop (tables/zones) + Sync POS.
- [ ] **(P2)** Multi‑floor + Templates.

### Notifications
- [ ] **(P1)** Drivers (email/SMS/push/in‑app) + Rate limits.
- [ ] **(P1)** Templates/i18n + Preferences center.
- [ ] **(P2)** Delivery logs/retries + Webhooks.
- **AC:** كل إشعار له Log وحالة تسليم.

---

## P2 — قيمة مضافة وتوسّع

### SelfServiceKiosk
- [ ] **(P2)** Kiosk flow + Upsell.
- [ ] **(P2)** Cashless + Digital receipt.
- [ ] **(P2)** Device lockdown + Offline queue.

### Membership
- [ ] **(P2)** Subscriptions & perks + Renewal/Grace.
- [ ] **(P2)** Perks gating عبر المنظومة.

### Marketplace
- [ ] **(P2)** Vendor onboarding/moderation.
- [ ] **(P2)** Listings/Filters/Search.
- [ ] **(P2)** Commission & payouts.

### FoodSafety
- [ ] **(P2)** HACCP checklists/temps + Corrective actions.
- [ ] **(P2)** Compliance exports + Batch/recall linkage.

### Training
- [ ] **(P2)** Courses/Lessons/Quizzes.
- [ ] **(P2)** Assignments/Tracking + Certification.

### Franchise
- [ ] **(P2)** Brand standards & sign‑off.
- [ ] **(P2)** Central menu/price pushes + Overrides.
- [ ] **(P2)** Royalty reports & store scorecards.

---

## P3 — عموديّات ثقيلة / سلاسل كبيرة

### EquipmentMonitoring
- [ ] **(P3)** IoT ingestion (MQTT/HTTP) + Thresholds/Alerts.
- [ ] **(P3)** Registry/Heartbeats + Dashboards.

### EquipmentMaintenance
- [ ] **(P3)** Work orders, PM schedules, parts.
- [ ] **(P3)** Technician SLAs + Costs/history.

### EnergyTracking
- [ ] **(P3)** Meter readings, tariffs + Alerts.
- [ ] **(P3)** Normalization per shift/store.

### EquipmentLeasing
- [ ] **(P3)** Lease contracts + Billing schedules.
- [ ] **(P3)** Delinquency/Dunning.

### Rentals
- [ ] **(P3)** Assets/spaces + Availability calendar.
- [ ] **(P3)** Contracts/Deposits/Billing.

### Jobs / HrJobs
- [ ] **(P3)** Job board/ATS, pipeline, offers/onboarding.
- [ ] **(P3)** Sync to users/roles on hire.

### EventManagement
- [ ] **(P3)** Setup/ticketing/capacity + Check‑in QR.
- [ ] **(P3)** Reports/Payouts.

### HotelPms
- [ ] **(P3)** Rooms/reservations/folios + Night audit.
- [ ] **(P3)** Route charges to POS + Housekeeping.
- [ ] **(P3)** Channel manager (later).

### ArVrMenu
- [ ] **(P3)** 3D assets pipeline (GLB/USDZ) + CDN.
- [ ] **(P3)** AR anchors/markers + Fallback 2D.
- [ ] **(P3)** Authoring/compression workflow.

---

## Patch‑Set فوري (Ready‑to‑ship)
- [ ] **TEN‑001**: تسجيل Tenancy + تطبيق Trait على كل الموديلات متعددة المستأجرين.
- [ ] **MOD‑002**: `tenant_modules` + FeatureFlag middleware.
- [ ] **RT‑003**: Broadcasting + Reverb + قنوات خاصة + Policies.
- [ ] **Q‑004**: Horizon/worker في Docker/Prod.
- [ ] **SEC‑005**: توحيد RBAC + Policies + MFA + Headers.
- [ ] **POS‑006**: Payments/Taxes/Printing/Shifts/Refunds/Offline.
- [ ] **INV‑007**: UOM/Recipes/Costing + Auto‑deduct.
- [ ] **KDS‑008**: Stations/Routes/State/SLA/Expo.
- [ ] **BILL‑009**: Cashier + Webhooks + Enforcement.
- [ ] **OBS‑010**: Sentry/Tracing/Metrics + Health Dashboard.
