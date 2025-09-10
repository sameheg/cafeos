# GAPS — كل ما ينقص السكربت (حسب الموديول)
**ملف تدقيقي صريح** — يوضح النواقص البنيوية (Wiring/Structure) والوظيفية (Features) لكل Module.

## فجوات شاملة (Global)
- Register TenancyServiceProvider in bootstrap/providers.php (tenancy events won't bootstrap automatically).
- Missing config/broadcasting.php and PUSHER/REVERB env keys → no realtime/KDS.
- docker-compose lacks a queue worker/Horizon service → jobs/notifications may stall.
- docker-compose lacks a WebSockets server (Reverb/Pusher proxy).
- Potential duplication of roles/permissions migrations between Core module and root — unify to avoid conflicts.
- No Authorization Policies across modules — enforce tenant-aware access via Policies/Gates.
- No automated tests (Feature/Unit/UI) across modules — add CI safety net.
- No Filament resources in modules — Admin lacks first-class CRUD/analytics for many domains.
- Missing i18n files for modules: ArVrMenu, Dashboard, EnergyTracking, EquipmentLeasing, EquipmentMonitoring, EventManagement, FoodSafety, Franchise, HotelPms.

> إحصائيات سريعة: 0 سياسات وصول، 0 اختبارات، 0 موارد Filament عبر كل الموديولات تقريبًا. كثير من الموديولات بلا views أو i18n.

---

## ArVrMenu
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- database migrations
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- 3D models hosting & CDN policies
- AR markers/anchors & device compatibility
- Fallback 2D experience
- Authoring pipeline (GLB/USDZ) & compression
---

## Billing
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Integrate Laravel Cashier (Stripe/Paddle) with subscriptions table
- Plan enforcement/feature gating across modules
- Dunning (retry strategy), proration, upgrade/downgrade flows
- Invoicing & receipt PDFs + EU VAT/EG/SA tax support
- Customer portal (update payment method, history)
- Webhooks handlers (invoice.payment_succeeded/failed, subscription events)
- Usage metering (orders/locations/seats) per tenant
---

## Core
**نواقص بنيوية (Wiring/Structure):**
- authorization policies
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Register TenancyServiceProvider in bootstrap/providers.php
- Global tenant scope Trait (BelongsToTenant) + base TenantModel
- Per-tenant module flags (tenant_modules table) + FeatureFlag middleware
- Sanctum multi-tenant API guards + rate limits/scopes
- Tenant Switcher: authorization & impersonation workflow
- RBAC unification (Spatie teams or single source of truth) + seeders
- Localization coverage (ar/en) for all core strings + RTL verification
- System Health page (DB/Cache/Queue/WebSockets/Scheduler) + runbooks
- Currency/timezone per tenant formatting middleware
- EventBus contracts & binding for cross-module events
---

## Crm
**نواقص بنيوية (Wiring/Structure):**
- authorization policies
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Unified customer profile & merge duplicates
- Segments & cohorting (new/returning)
- Communication history & consent (GDPR-like)
- Marketing preferences & suppression list
- RFM/CLV estimation (basic)
---

## Dashboard
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- database migrations
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Executive KPIs + trends
- System health widgets (workers/ws/scheduler)
- Shortcut cards (add product, open shift)
---

## EnergyTracking
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- database migrations
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Meter readings (manual/API), tariffs
- Consumption dashboards & per-shift normalization
- Alerts for unusual spikes
---

## EquipmentLeasing
**نواقص بنيوية (Wiring/Structure):**
- views
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Lease contracts, billing schedules
- Asset tracking & returns
- Delinquency/dunning
---

## EquipmentMaintenance
**نواقص بنيوية (Wiring/Structure):**
- views
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Work orders, PM schedules, parts
- Technician assignments & SLAs
- Cost tracking & history
---

## EquipmentMonitoring
**نواقص بنيوية (Wiring/Structure):**
- tenant_id in migrations
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Telemetry ingestion (IoT), thresholds & alerts
- Device registry & heartbeats
- Dashboards & anomaly detection (basic)
---

## EventManagement
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- database migrations
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Event setup, ticket types, capacity
- Check-in QR & scanners
- Reports & payouts
---

## FloorPlanDesigner
**نواقص بنيوية (Wiring/Structure):**
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Drag&drop editor (tables/zones/covers)
- Sync to POS seating
- Multi-floor support & templates
---

## FoodSafety
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- tenant_id in migrations
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- HACCP checklists & temperature logs
- Corrective actions & attachments/photos
- Audit trails & compliance exports
- Batch/recall linkage
---

## Franchise
**نواقص بنيوية (Wiring/Structure):**
- views
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Brand standards, policy distribution & sign-off
- Centralized menu/pricing pushes
- Royalty reports & store scorecards
---

## HotelPms
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- database migrations
- config/permissions
- authorization policies
- i18n (ar/en)
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Room inventory, reservations, folios
- Check-in/out, charges routing to POS
- Night audit & housekeeping
- Channel manager integration (future)
---

## HrJobs
**نواقص بنيوية (Wiring/Structure):**
- views
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- ATS features (external candidates)
- Offer letters & onboarding tasks
- Sync to users/roles (on hire)
---

## Inventory
**نواقص بنيوية (Wiring/Structure):**
- authorization policies
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Units of measure (UOM) & conversions
- Recipes/BOM with automatic deduction on sale
- Costing methods (Avg/FIFO/LIFO) & COGS calc
- Stock transfers, stocktake, waste/spoilage
- Min/max stock levels & alerts
- Supplier item linkage & 86-list integration
- Batch/lot tracking (optional)
---

## Jobs
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- database migrations
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Internal job board, postings, applications
- Pipeline stages & notes
- Basic reporting & exports
---

## Kds
**نواقص بنيوية (Wiring/Structure):**
- tenant_id in migrations
- HTTP controllers
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Stations, routing rules (SKU/Category → Station), station groups
- State machine (queued→in_progress→ready→expo→served/recall)
- Private WebSocket channels per tenant/station + policies
- SLA timers & aging colors, sound alerts
- Expo screen & completeness checks
- Device heartbeat/provisioning + kiosk mode
- Resync/diff on reconnect + sequencing
- Capacity & load balancing between stations
- Fallback to kitchen printer if WS fails
---

## Loyalty
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Rules engine (earn/redeem) + tiers
- Ledger of points with expiry & adjustments
- Fraud checks & limits
- POS integration (apply/redeem at checkout)
- Campaign hooks & vouchers
---

## Marketplace
**نواقص بنيوية (Wiring/Structure):**
- views
- authorization policies
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Vendor onboarding & moderation
- Listings, categories, search & filters
- Commission & payouts
- Orders/escrow (if transactional)
---

## Membership
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Customer subscriptions & perks
- Renewal reminders & grace periods
- Perks gating across modules
---

## Notifications
**نواقص بنيوية (Wiring/Structure):**
- views
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Channel drivers (email/SMS/push/in-app) with rate limits
- Templates & localization
- User/tenant preferences center
- Delivery logs & retries
---

## Pos
**نواقص بنيوية (Wiring/Structure):**
- authorization policies
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Multi-tender payments (cash/card/wallet) + split/merge bills
- Taxes/Service/Fees rules (item/order level) + rounding
- Discounts & Overrides with Manager PIN + audit
- ESC/POS printing & drawer kick + kitchen/receipt printers mapping
- Order types (Dine-in/Takeaway/Delivery) + table management
- Shifts/Till (open/close, cash movements, X/Z reports)
- Refund/Void policies with inventory reverse & credit receipt
- Offline-first queue (IndexedDB, background sync, dedupe)
- KDS events integration (fire/start/ready/recall)
- Device provisioning & screen lock (PIN)
---

## Procurement
**نواقص بنيوية (Wiring/Structure):**
- routes (web/api)
- tenant_id in migrations
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- RFQ → PO → GRN/Invoice (3-way match)
- Supplier catalogs & price lists
- Lead times & delivery schedules
- Approvals workflow & thresholds
- Spend reports & supplier performance
- Integration to Inventory for receiving
---

## QrOrdering
**نواقص بنيوية (Wiring/Structure):**
- database migrations
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Table/zone QR mapping & anti-spoofing
- Menu with modifiers & availability
- Checkout (pay at table or counter) + status updates
- Order throttling & pickup ETA
- PWA offline & device binding for tables
---

## Rentals
**نواقص بنيوية (Wiring/Structure):**
- views
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Assets/spaces catalog, availability calendar
- Booking, deposits, contracts
- Billing & damages workflow
---

## Reports
**نواقص بنيوية (Wiring/Structure):**
- database migrations
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Sales KPIs (Net sales, AOV, Void/Discount, GP%)
- Inventory KPIs (COGS, stock turns, DOH)
- Scheduling (daily/weekly emails) + PDF/CSV export
- Pre-aggregations/caching for performance
- Drilldowns to orders/lines
- Multitenant partitioning in warehouse
---

## SelfServiceKiosk
**نواقص بنيوية (Wiring/Structure):**
- tenant_id in migrations
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Kiosk flow with item mods & upsell
- Cashless checkout + receipt delivery
- Device lockdown & offline queue
- Sanitizable UI & accessibility
---

## SuperAdmin
**نواقص بنيوية (Wiring/Structure):**
- database migrations
- HTTP controllers
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Module manager per tenant with versions & health
- Impersonation & audit trails
- Config editor (env overrides) guarded
- Usage metering dashboards
---

## TableReservations
**نواقص بنيوية (Wiring/Structure):**
- tenant_id in migrations
- views
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Time slots & capacity per floor/table
- Holds, no-show policies, deposits
- Integration with FloorPlan/Pos (seat→open tab)
- Waitlist & SMS notifications
---

## Training
**نواقص بنيوية (Wiring/Structure):**
- HTTP controllers
- views
- config/permissions
- authorization policies
- seeders
- automated tests
- Filament resources

**نواقص وظيفية (Features):**
- Courses, lessons, quizzes
- Assignments & tracking
- Certification & expiry reminders

---

## Patch‑Set مقترح (خطوات تنفيذية قصيرة)
- [TEN-001] أضف `App\Providers\TenancyServiceProvider::class` إلى `bootstrap/providers.php`.
- [RT-002] أضف `config/broadcasting.php` + Reverb/Pusher مفاتيح، وخدمة WebSockets في Docker.
- [Q-003] أضف Horizon/queue worker للخدمة الإنتاجية.
- [SEC-004] أضف Policies لكل موديل متعدد المستأجرين، واعتمد Trait `BelongsToTenant` (أو BaseModel).
- [ADM-005] أنشئ موارد Filament لكل كيانات CRUD حرجة (POS/Inventory/CRM/Procurement…).
- [I18N-006] أكمل تغطية i18n (ar/en) وRTL لكل الشاشات.
- [QA-007] أضف اختبارات Feature/Unit أساسية وشغّل CI في GitHub Actions.
- [BILL-008] دمج Cashier + خطط + Webhooks وتفعيل القيود per‑tenant.
- [RT-009] بث لحظي KDS/Orders + قنوات خاصة لكل `tenant_id`.