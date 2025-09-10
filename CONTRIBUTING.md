📝 Contributing Guidelines
🌍 Multi-Language & RTL Support (إلزامي)

⚠️ كل Feature جديدة لازم تدعم تعدد اللغات (EN/AR على الأقل) + RTL.
أي كود بدون دعم كامل مرفوض 🚫.

🏛️ General Rules

جميع النصوص ممنوع تتكتب في الكود مباشرة.

✅ __('dashboard.title')

❌ "Dashboard"

الترجمات تتحط في ملفات:

lang/en.json (English)

lang/ar.json (Arabic, RTL)

أي Model يحتوي نصوص (اسم، وصف) لازم يستخدم:

use Spatie\Translatable\HasTranslations;
protected $translatable = ['name', 'description'];

🎨 Frontend (Vue/Inertia + Tailwind)

استخدم vue-i18n@9 لكل النصوص داخل Vue Components.

Tailwind لازم يحتوي على RTL Plugin مفعّل.

أي Layout يدعم:

<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">


الأيقونات/الأسهم لازم تنعكس حسب الاتجاه (RTL/LTR).

💵 Currency & Locale

الأسعار تتعرض حسب عملة الـ Tenant.

التاريخ/الأرقام تتحول تلقائيًا حسب Locale (Carbon::locale()).

الـ Reports لازم تدعم Multi-Currency.

📲 Modules Special Cases

QR Menu: يفتح بلغة الـ Tenant الافتراضية + خيار لتغيير لغة العميل.

Notifications: ترسل بلغة المستلم (SMS/Email/Push).

Floor Plan Designer: يدعم سحب/إفلات RTL (يمين → شمال).

Marketplace & Jobs: المنتجات/الإعلانات تدعم أوصاف متعددة اللغات.

✅ Quality Checks

Manual Test باللغتين (EN + AR).

UI Test في وضع RTL على الأقل على:

POS

Reports

Snapshot Testing للـ translations.

CI/CD pipeline لازم يحتوي:

php artisan lang:check


عشان يمنع أي Missing Keys.

🚦 Acceptance Criteria

كل Feature جديدة لازم تسلم بـ ترجمات EN + AR.

أي UI لازم يمر باختبار RTL.

أي نص/Label بدون دعم i18n → Pull Request يتقفل فورًا.

🔥 قاعدة ذهبية:

"لا كود بدون i18n + RTL"


🏗️ Development Guide (For All Modules)
🎯 Purpose

This project is a SaaS Modular System for restaurants & cafés.
Each module (POS, Inventory, CRM, etc.) must be built as a self-contained unit with:

Its own database tables.

Frontend components.

Admin panel (Filament).

API endpoints.

Events & service integrations.

📦 1. Module Structure

Every module lives inside Modules/{ModuleName}.

Example structure:

Modules/
  └── Pos/
      ├── Database/Migrations
      ├── Http/Controllers
      ├── Models
      ├── Resources (Filament)
      ├── Routes
      ├── Services
      └── Tests


Each module must be able to run independently (enable/disable without breaking the system).

🔑 2. Roles & Permissions

Use spatie/laravel-permission.

Each module defines its own permissions (e.g. pos.create_order, inventory.adjust_stock).

Roles must include:

Manager

Cashier

Waiter

Chef

Delivery

Tenant Admin can assign permissions per staff member.

🛢️ 3. Database

Each module must have its own tables with mandatory tenant_id.

Migrations must be generated via `php artisan make:migration` so that filenames use real timestamps and remain in chronological order.

Every migration must include:

$table->foreignId('tenant_id')->index();
$table->timestamps();
$table->softDeletes();


Cross-module relations should be done via Events/Services (not direct FK) unless absolutely necessary.

🖥️ 4. Frontend

Built with Vue 3 + Inertia + Tailwind.

Must support Multi-Language + RTL (using vue-i18n).

Each module should have its own components in:

resources/js/Modules/{ModuleName}/


All texts must come from translation files (lang/en.json, lang/ar.json).

🧭 5. Admin Panel

Use Filament v4 for management interfaces.

Each module must add its own Filament resources (e.g. OrdersResource, InventoryResource).

Dashboards separated by role:

Tenant Manager: sees only their branch.

Super Admin: sees all tenants.

🔗 6. Integrations

Communication between modules must be via:

Events → e.g. OrderCreated triggers Inventory updates.

Services/Contracts → interface-based integrations.

Direct module-to-module calls are forbidden (to keep isolation).

📊 7. Reporting

Each module provides its own reports.

A central Reports module aggregates data.

All reports must support:

Filters by time range.

Filters by staff/customer/item.

Export (CSV, Excel, PDF).

🌍 8. Multi-Language & RTL

Mandatory: EN + AR support from day one.

Each module must ship with lang/en.json and lang/ar.json.

All UIs must be tested in RTL mode.

🧪 9. Testing

Every module must include:

Feature Tests (Controllers, APIs).

Unit Tests (Services, calculations).

UI Tests (Inertia pages).

Target test coverage: 80%+.

🚦 10. CI/CD

Each Pull Request must pass:

php artisan test

npm run build

php artisan lang:check (to ensure no missing translations).

Any PR that fails → rejected.

⚡ 11. Performance & Security

Use Redis for per-tenant sessions & caching.

Queue jobs must be scoped by tenant_id.

Sensitive data (API Keys, Tokens) stored in .env or Secret Manager.

🧭 12. Developer Quick Rules

New module must include: Migration + Model + Controller + Routes + Filament Resource + Vue Components + Translations + Tests.

Must support Multi-Tenancy (tenant_id).

Must be isolated (independent from others).

Must support EN/AR + RTL.

Must include tests + documentation.

🔥 Golden Rule:

Each module = an "independent country" inside the union.
Works standalone + works together.
