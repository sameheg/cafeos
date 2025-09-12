# POS Module — FINAL (Production-Ready)

هذه النسخة تُغلق جميع النواقص وتُحوّل الـPOS لنظام مؤسسي متكامل.

## ✅ ما الذي يشمله الآن؟
- **دورة الطلب كاملة**: new → in_progress → served → paid → closed
- **Items + Modifiers + Split Bills**
- **Totals & Taxes & Service & Currency**
- **Customers + Tables + Reservations Guard**
- **Payments (Idempotent) + Discounts + Refunds/Void**
- **Inventory (BOM) Integration**: خصم/إرجاع مكونات الـBOM تلقائيًا
- **Billing Integration**: إنشاء فاتورة فعلية (جداول Billing) أو بث حدث إن لم تتوفر
- **Loyalty Integration**: منح نقاط للعميل عند الدفع
- **KDS/WebSocket Events**: تحديثات حالة الطلب/المطبخ
- **Audit Logs مُفروضة**: تُسجَّل لكل Payment/Discount/Refund
- **RBAC دقيق**: صلاحيات للكاشير/الويتر/المدير
- **Offline Sync**: تطبيق Mutations مع مفاتيح Idempotency
- **Observability**: /health و /metrics
- **Hardware**: طباعة ESC/POS عبر TCP وفتح الدرج
- **OpenAPI**: عقود محدثة في `docs/openapi.json`

## 🔧 التثبيت
```bash
php artisan migrate
php artisan db:seed --class=Modules\Pos\Database\Seeders\PosDemoSeeder
php artisan optimize:clear
```

## 🔌 نقاط التكامل
- **Inventory**: يعتمد على `inventory_boms` و/أو `item.meta.bom` + جدول `inventory_items` إن وُجد.
- **Billing**: يكتب إلى `billing_invoices` (+ `billing_invoice_items` إن وُجد) أو يُصدر Event خارجي.
- **Reservations**: يتحقق من جدول `reservations` قبل بدء الطلب.
- **Loyalty**: يسجّل في `loyalty_points` عند الدفع.
- **Hardware**: يرسل أوامر ESC/POS لطابعة شبكة `ip:port`.

> جميع التكاملات تُجرى بفحوصات وجود الجداول (Schema::hasTable) لضمان الأمان عبر البيئات.

## 🧪 واجهات برمجية مهمة
- Payments: `POST /api/v1/pos/order/{order}/pay`
- Discounts: `POST /api/v1/pos/order/{order}/discount`
- Refunds: `POST /api/v1/pos/order/{order}/refund`
- Bills (Split): `GET/POST /api/v1/pos/order/{order}/bills`, `POST /bills/{bill}/items`
- Kitchen: `PATCH /api/v1/pos/item/{item}/kitchen/{status}`
- Promotions: `GET /api/v1/pos/promotions`, `POST /api/v1/pos/order/{order}/promotions/apply`
- Delivery: `POST /api/v1/pos/order/{order}/delivery/assign`, `PATCH /delivery/{status}`
- Offline: `POST /api/v1/pos/offline/token`, `POST /api/v1/pos/offline/push`
- Health/Metrics: `GET /api/v1/pos/health`, `GET /api/v1/pos/metrics`

## 🛡️ الأمان والحوكمة
- **Idempotency** عبر Header و/أو offline mutation keys.
- **Audit Logs إلزامية** للعمليات الحساسة.
- **RBAC**: افصل أدوار Cashier/Manager/Waiter وامنح صلاحيات دقيقة.

## 📈 التقارير
- Daily, Top Items, P&L, Occupancy — جاهزة وتتمدّد حسب احتياجك.

## 🚀 نصائح تشغيل
- اربط WebSockets لقناة `tenant.{tenant_id}.kds` لشاشات KDS/Waiter UI.
- فعّل قواعد Loyalty/Promotions حسب استراتيجيتك.
- طبّق BOM & Unit Conversions في جداول Inventory الخاصة بك (إن لم تكن موجودة، استخدم `item.meta.bom`).

