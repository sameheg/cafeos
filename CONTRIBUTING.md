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
