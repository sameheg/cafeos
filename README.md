
# CafeOS — منصة SaaS متكاملة للمطاعم والكافيهات
**Laravel 12 + Vue 3 + Inertia + PWA + POS + KDS + Inventory + CRM + Reports + Multi‑Tenancy + Billing**

> *من الآخر:* CafeOS مش “سكريبت”، دي **منصّة أعمال** جاهزة للنمو: بيع سريع (POS)، مطبخ لحظي (KDS)، مخزون دقيق، تقارير تنفيذية، فواتير واشتراكات، وتشغيل متعدد المستأجرين (tenants) على مستوى المؤسسات.

[![Build](https://img.shields.io/badge/build-passing-brightgreen)](#)
[![PHP](https://img.shields.io/badge/php-8.3-blue)](#)
[![Laravel](https://img.shields.io/badge/laravel-12-red)](#)
[![License](https://img.shields.io/badge/license-AGPL--3.0-black)](#)

---

## 🔎 لماذا CafeOS؟ (Value Prop)
- **يولّد إيرادًا من اليوم الأول**: POS + Billing + خطط اشتراك + قيود ميزات.
- **سرعة التشغيل**: KDS لحظي، Offline‑first، طباعة ESC/POS، X/Z، شِفتات وكاش دراور.
- **حَوْكمة سهلة**: SuperAdmin يُشغّل/يوقف الموديولات **لكل مستأجر** بضغطة.
- **تكاليف أقل**: وصفات/BOM + COGS + تنبّه للمخزون المنخفض + تقارير قابلة للتصدير.
- **قابلية توسّع**: بنية Modules، Feature Flags، Events Bus، وCI/CD جاهز.

---

## 🧱 المعمارية (Architecture)
- **Monolith Modular** عبر `nwidart/modules` مع **Feature Flags per‑tenant**.
- **Multi‑Tenancy** via `stancl/tenancy`: عزل قواعد بيانات/سكيمات، Middleware، وScopes.
- **واجهة**: Vue 3 + Inertia + Pinia + Tailwind + RTL جاهز.
- **Realtime**: Laravel Reverb/ Pusher + قنوات خاصة لكل `tenant_id` + Policies.
- **Queues**: Horizon/Workers للمهام والاشعارات.
- **PWA/Offline**: IndexedDB + Background Sync + استراتيجيات Cache واضحة.
- **Observability**: Sentry/Tracing + Metrics (Prometheus) + صفحة Health.

```
cafeos/
├─ app/ (النواة العامة)
├─ Modules/
│  ├─ Core/            (Tenancy, RBAC, Feature Flags, EventBus)
│  ├─ SuperAdmin/      (حوكمة وImpersonation وModule Manager)
│  ├─ Billing/         (Cashier + Plans + Webhooks + Enforcement)
│  ├─ Pos/             (Checkout, Shifts, Printing, Offline)
│  ├─ Kds/             (Stations, Routing, Expo, SLA, Realtime)
│  ├─ Inventory/       (UOM, Recipes/BOM, COGS, Transfers/Stocktake)
│  ├─ Procurement/     (RFQ→PO→GRN/Invoice + Approvals)
│  ├─ Crm/             (Profiles, Segments, Consent)
│  ├─ Loyalty/         (Rules, Ledger, Expiry, POS hooks)
│  ├─ QrOrdering/      (QR Tables, Checkout, Anti‑spoofing)
│  ├─ TableReservations/ (Slots, Holds/Deposits, Waitlist)
│  ├─ FloorPlanDesigner/ (خرائط صالة متزامنة مع POS)
│  ├─ Notifications/   (Email/SMS/Push/In‑app + Templates)
│  ├─ Reports/         (Sales, COGS, AOV, Schedulers/Exports)
│  ├─ Dashboard/       (KPIs تنفيذية + System Health)
│  └─ ...              (Modules إضافية: Franchise, Marketplace, Jobs, ...)
├─ bootstrap/providers.php  (تسجيل ServiceProviders)
├─ config/ (بما فيها broadcasting, horizon, queue, cache, tenancy ...)
└─ docker-compose.yml
```

---

## 🚀 التشغيل السريع (Quick Start)

### 0) المتطلبات
- **Docker** (مستحسن) أو: PHP 8.3، Composer، Node 20، Redis، MySQL/Postgres.
- دومين/ساب دومين محلي (e.g. `cafeos.test`, `tenant1.cafeos.test`).

### 1) الإعداد
```bash
git clone <repo-url> cafeos && cd cafeos
cp .env.example .env
composer install
npm ci && npm run build   # أو npm run dev
php artisan key:generate
```

### 2) تهيئة الـ Tenancy
```bash
php artisan tenancy:install         # جداول المركز
php artisan migrate --force         # مهاجرات المركز
php artisan tenants:create --domain="tenant1.localhost"
php artisan tenants:migrate --tenant=tenant1.localhost
```

> **مهم:** تأكد أن `App\Providers\TenancyServiceProvider::class` مسجّل في `bootstrap/providers.php` وأن كل موديل متعدد المستأجرين يورّث `TenantModel`/Trait `BelongsToTenant`.

### 3) البث اللحظي والصفوف
```bash
php artisan horizon     # أو queue:work
php artisan reverb:start  # إن استخدمت Reverb
```

### 4) تكوين البيئة (ENV)
- **Broadcasting**: `BROADCAST_DRIVER=pusher` + مفاتيح `PUSHER_*` أو Reverb.
- **Queue**: `QUEUE_CONNECTION=redis`, **Cache**: `redis`.
- **Tenancy**: `TENANCY_BOOTSTRAP=true`, `TENANCY_CENTRAL_DOMAIN=cafeos.test`.
- **Billing (Stripe/Paddle)**: `STRIPE_KEY`, `STRIPE_SECRET`, `CASHIER_*`…
- **Mail/SMS**: إعدادات SMTP وSMS provider.

### 5) بيانات أولية (اختياري)
```bash
php artisan db:seed        # أدوار افتراضية، Tenant demo، إلخ
```

---

## 📦 الموديولات الأساسية (حسب الأولوية)

### P0 — إطلاق المنصة
- **Core**: Tenancy، RBAC، Feature Flags، EventBus، Health.
- **SuperAdmin**: Module Manager per‑tenant، Impersonation، Audit.
- **Billing**: Cashier + Plans + Webhooks + Enforcement.
- **Pos**: Multi‑tender، Split/Merge، Taxes/Service/Fees، Printing، Shifts/XZ، Refund/Void، Offline‑first.
- **Inventory**: UOM، Conversions، Recipes/BOM، COGS، Transfers/Stocktake.
- **Kds**: Stations/Routes، State machine، Expo، SLA/Colors، Realtime.
- **Reports**: X/Z + Daily Sales + Top SKUs + Discounts/Void.
- **Dashboard**: KPIs تنفيذية + System Health.

### P1 — تثبيت التشغيل ونمو الإيراد
- **Procurement**، **Crm**، **Loyalty**، **QrOrdering**، **TableReservations**، **FloorPlanDesigner**، **Notifications** (مع Templates وPreference Center).

### P2 — قيمة مضافة
- **SelfServiceKiosk**، **Membership**، **Marketplace**، **FoodSafety**، **Training**، **Franchise**.

### P3 — عموديّات ثقيلة
- **EquipmentMonitoring/Maintenance/Leasing**، **EnergyTracking**، **Rentals**، **Jobs/HrJobs**، **EventManagement**، **HotelPms**، **ArVrMenu**.

> كل موديول **BelongsToTenant** + سياسات وصول + موارد Filament للحوكمة.

---

## 💳 الفوترة والاشتراكات (Billing)
- Cashier (Stripe/Paddle)، Webhooks، Dunning/Proration، Portal.
- **Plan Enforcement**: فتح/غلق ميزات حسب الخطة (Feature Flags).
- **Usage Metering**: Orders/Seats/Locations per‑tenant.
- **Fiscalization** (اختياري): EG/KSA e‑Invoice + QR + تسلسل فواتير.

---

## 🖨️ الأجهزة والطباعة
- **ESC/POS**: قوالب إيصال (RTL/QR) + Drawer kick.
- **Printers Mapping**: مطبخ/إيصال/بار.
- **Device Provisioning**: أكواد تسجيل، Heartbeat، Kiosk mode.
- **Customer Display** (اختياري): سلة لحظية + Tips.

---

## 🌐 i18n & RTL
- تغطية كاملة AR/EN، RTL + أرقام عربية، تنسيقات عملات/مناطق.
- Localization Manager لاكتشاف المفاتيح الناقصة واستيراد/تصدير JSON.

---

## 🔒 الأمن والامتثال
- MFA، Rate limiting، Security headers (CSP/HSTS/COOP/CORP)، Cookies آمنة.
- سياسات صلاحيات دقيقة، Audit لا يُمكن التلاعب به (append‑only).
- خصوصية/حذف/تصدير بيانات per‑tenant، DPA، Cookies consent.

---

## 📈 الأداء والمراقبة
- ميزانيات أداء: إضافة صنف للسلة ≤ **50ms**، إغلاق بيع ≤ **2s**، طباعة ≤ **1s**.
- Observability: Sentry + Tracing + Metrics (p95/p99، Errors/min).
- صفحة **System Health**: DB/Queue/WebSockets/Scheduler مع توصيات إصلاح.

---

## 🧪 الاختبارات وCI/CD
- **Pest/PHPUnit** (Feature/Unit/UI) + **Playwright/Cypress** (E2E).
- GitHub Actions: Pint، PHPStan، Test، Build، Docker publish.
- Zero‑downtime migrations + Blue/green أو Canary deploys.

---

## 🧭 خارطة الطريق (ملخّص)
- P0 وP1 جاهزين للإنتاج. P2/P3 حسب السوق (ARPU/التوسّع القطاعي).
- انظر `GAPS_V2.md` و`GAPS_V2_TASKS.json` لقوائم التنفيذ المفصّلة.

---

## 🙌 المساهمة (Contributing)
1. افتح Issue بعنوان واضح وأولوية (P0–P3).
2. اعمل فرعًا `feature/<scope>`، التزم بمعيار Conventional Commits.
3. شغّل الاختبارات محليًا، وارفق لقطات/تسجيل قصير للواجهة عند الحاجة.
4. افتح PR مع وصف، خطوات اختبار، وأثر الأداء/الأمن.

---

## 📜 الترخيص
AGPL‑3.0 — استخدام حر، التعديلات المنشورة يجب أن تكون مفتوحة المصدر.

---

## 📞 الدعم
- **مشاكل حرجة (Production)**: افتح Issue مع الوسم `priority:P0`.
- **أسئلة عامة**: Discussions/Slack.
- **عقود دعم/استضافة مُدارة**: راسلنا على `support@cafeos.example`.

> لو احتجت **عرض ديمو** سريع: شغّل Seeders، فعّل Tenant demo، ثم افتح `tenant1.localhost` — استمتع. القعدة فرض… والمزاج سنة 😎
