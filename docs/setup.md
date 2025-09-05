# دليل الإعداد

## المتطلبات

- **PHP**: الإصدار 8.0 أو أحدث.
- **Composer**: لإدارة حزم PHP.
- **Node.js** و**npm**: لتجميع الأصول وتشغيل اختبارات الواجهة.

## إعداد ملف البيئة `.env`

1. انسخ الملف النموذجي:
   ```bash
   cp .env.example .env
   ```
2. أنشئ مفتاح التطبيق:
   ```bash
   php artisan key:generate
   ```
3. حرر القيم بما يناسب بيئتك.

### المتغيرات المتاحة

#### إعداد التطبيق
- `APP_NAME`: اسم التطبيق.
- `APP_TITLE`: عنوان إضافي للواجهة.
- `APP_ENV`: بيئة التشغيل (local, production...).
- `APP_KEY`: مفتاح التشفير للتطبيق.
- `APP_DEBUG`: تفعيل وضع التصحيح.
- `APP_LOG_LEVEL`: مستوى تسجيل الأخطاء.
- `APP_URL`: عنوان الموقع الأساسي.
- `APP_LOCALE`: اللغة الافتراضية.
- `APP_TIMEZONE`: المنطقة الزمنية.

#### التحكم بالمستخدمين
- `ADMINISTRATOR_USERNAMES`: أسماء المستخدمين الإداريين المسموح لهم.
- `ALLOW_REGISTRATION`: السماح بالتسجيل العام.
- `ENABLE_GST_REPORT_INDIA`: تمكين تقارير GST للهند.
- `SHOW_REPAIR_STATUS_LOGIN_SCREEN`: إظهار حالة الإصلاح في شاشة الدخول.

#### السجلات والمعاملات
- `LOG_CHANNEL`: قناة حفظ السجلات.
- `POS_RECENT_TRANSACTIONS_DISPLAY_LIMIT`: عدد آخر المعاملات المعروضة في نقطة البيع.

#### قاعدة البيانات
- `DB_CONNECTION`: نوع الاتصال بقاعدة البيانات.
- `DB_HOST`: عنوان الخادم.
- `DB_PORT`: منفذ الاتصال.
- `DB_DATABASE`: اسم قاعدة البيانات.
- `DB_USERNAME`: اسم المستخدم.
- `DB_PASSWORD`: كلمة المرور.

#### التخزين المؤقت والطوابير
- `BROADCAST_DRIVER`: محرك البث للأحداث.
- `CACHE_DRIVER`: محرك التخزين المؤقت.
- `SESSION_DRIVER`: محرك الجلسات.
- `QUEUE_CONNECTION`: محرك الطوابير.
- `REDIS_HOST`: خادم Redis.
- `REDIS_PASSWORD`: كلمة مرور Redis.
- `REDIS_PORT`: منفذ Redis.

#### البريد
- `MAIL_MAILER`: نوع موصل البريد.
- `MAIL_HOST`: خادم البريد.
- `MAIL_PORT`: منفذ البريد.
- `MAIL_USERNAME`: اسم المستخدم للبريد.
- `MAIL_PASSWORD`: كلمة مرور البريد.
- `MAIL_ENCRYPTION`: بروتوكول التشفير.
- `MAIL_FROM_ADDRESS`: عنوان المرسل.
- `MAIL_FROM_NAME`: اسم المرسل.

#### Pusher والبث
- `PUSHER_APP_ID`: معرّف تطبيق Pusher.
- `PUSHER_APP_KEY`: مفتاح تطبيق Pusher.
- `PUSHER_APP_SECRET`: السر الخاص بالتطبيق.
- `PUSHER_APP_CLUSTER`: مجموعة Pusher المستخدمة.

#### التراخيص والنسخ الاحتياطي
- `ENVATO_PURCHASE_CODE`: كود شراء Envato.
- `MAC_LICENCE_CODE`: كود ترخيص MAC.
- `BACKUP_DISK`: القرص المستخدم للنسخ الاحتياطي.
- `DROPBOX_ACCESS_TOKEN`: رمز الوصول إلى Dropbox.

#### بوابات الدفع
- `STRIPE_PUB_KEY` / `STRIPE_SECRET_KEY`: بيانات Stripe.
- `PAYPAL_CLIENT_ID` / `PAYPAL_APP_SECRET` / `PAYPAL_MODE`: إعدادات PayPal الحديثة.
- `PAYPAL_SANDBOX_API_USERNAME` / `PAYPAL_SANDBOX_API_PASSWORD` / `PAYPAL_SANDBOX_API_SECRET`: بيانات PayPal وضع الاختبار (قديم).
- `PAYPAL_LIVE_API_USERNAME` / `PAYPAL_LIVE_API_PASSWORD` / `PAYPAL_LIVE_API_SECRET`: بيانات PayPal وضع الإنتاج (قديم).
- `RAZORPAY_KEY_ID` / `RAZORPAY_KEY_SECRET`: بيانات Razorpay.
- `PESAPAL_CONSUMER_KEY` / `PESAPAL_CONSUMER_SECRET` / `PESAPAL_CURRENCY` / `PESAPAL_LIVE`: إعدادات Pesapal.
- `PAYSTACK_PUBLIC_KEY` / `PAYSTACK_SECRET_KEY` / `PAYSTACK_PAYMENT_URL` / `MERCHANT_EMAIL`: إعدادات Paystack.
- `FLUTTERWAVE_PUBLIC_KEY` / `FLUTTERWAVE_SECRET_KEY` / `FLUTTERWAVE_ENCRYPTION_KEY`: بيانات Flutterwave.
- `MY_FATOORAH_API_KEY` / `MY_FATOORAH_IS_TEST` / `MY_FATOORAH_COUNTRY_ISO`: إعدادات MyFatoorah.

#### خدمات إضافية
- `GOOGLE_MAP_API_KEY`: مفتاح خرائط Google.
- `OPENAI_API_KEY` / `OPENAI_ORGANIZATION`: مفاتيح استخدام OpenAI.
- `AWS_ACCESS_KEY_ID` / `AWS_SECRET_ACCESS_KEY` / `AWS_DEFAULT_REGION` / `AWS_BUCKET`: إعدادات نسخ S3.
- `ENABLE_RECAPTCHA` / `GOOGLE_RECAPTCHA_KEY` / `GOOGLE_RECAPTCHA_SECRET`: إعدادات reCAPTCHA.
- `TWILIO_WHATSAPP_SID` / `TWILIO_WHATSAPP_TOKEN` / `TWILIO_WHATSAPP_FROM`: بيانات Twilio WhatsApp.
- `TALABAT_CLIENT_ID` / `TALABAT_CLIENT_SECRET` / `TALABAT_BASE_URI`: تكامل Talabat.
- `UBEREATS_CLIENT_ID` / `UBEREATS_CLIENT_SECRET` / `UBEREATS_BASE_URI`: تكامل UberEats.

## الوحدات المفعّلة

يحتوي الملف `modules_statuses.json` على حالة كل وحدة. القيمة `true` تعني أن الوحدة مفعّلة و`false` تعني أنها معطّلة. يمكن التعديل يدويًا أو عبر أوامر Artisan:

```bash
php artisan module:enable ModuleName
php artisan module:disable ModuleName
```

### قائمة الوحدات
- `Essentials`: وظائف النظام الأساسية.
- `Accounting`: المحاسبة وإدارة الحسابات.
- `AssetManagement`: إدارة الأصول والمعدات.
- `Cms`: نظام إدارة المحتوى.
- `Connector`: الربط مع خدمات خارجية.
- `Crm`: إدارة علاقات العملاء.
- `Ecommerce`: المتجر الإلكتروني.
- `FieldForce`: إدارة فرق العمل الميدانية.
- `Manufacturing`: وظائف التصنيع.
- `ProductCatalogue`: كتالوج المنتجات العام.
- `Project`: إدارة المشاريع.
- `Repair`: إدارة عمليات الصيانة والإصلاح.
- `Spreadsheet`: تكامل جداول البيانات.
- `Superadmin`: خصائص المشرف العام.
- `Woocommerce`: تكامل WooCommerce.
- `AiAssistance`: مساعد الذكاء الاصطناعي.
- `Hms`: إدارة المستشفى أو العيادة.
- `InboxReport`: تقارير البريد الوارد.
- `CustomDashboard`: لوحات التحكم المخصصة.
- `Gym`: إدارة النوادي الرياضية.
- `ZatcaIntegrationKsa`: تكامل هيئة الزكاة والضريبة (السعودية).
- `ModuleName`: مثال على وحدة مخصّصة.

لتعطيل وحدة، غيّر قيمتها إلى `false` في `modules_statuses.json` أو استخدم أمر التعطيل أعلاه.


## تشغيل عمال الطوابير

لتنفيذ المهام في الخلفية (مثل مزامنة الطلبات أو توليد التقارير) يجب تشغيل عامل الطوابير:

```bash
php artisan queue:work redis --tries=3
```

يُنصح باستخدام أداة مثل **Supervisor** أو خدمة مشابهة لإعادة تشغيل العامل تلقائيًا ومراقبة الأعطال.

## جدولة المهام

يعتمد التطبيق على نظام الجدولة في Laravel لتشغيل أوامر الصيانة اليومية. تأكد من ضبط Cron لتشغيل الأمر التالي كل دقيقة:

```bash
* * * * * php artisan schedule:run >> /dev/null 2>&1
```

تشمل المهام المجدولة الحالية:

- `pos:checkLowStock` — يفحص المنتجات ذات المخزون المنخفض يوميًا.
- `pos:forecastDemand` — يحدّث توقع الطلب يوميًا.
