# إنشاء موديولات جديدة

يوضح هذا المستند كيفية إنشاء وحدة جديدة اعتماداً على القالب الموجود في `examples/ModuleTemplate`.

1. انسخ مجلد القالب إلى مجلد الوحدات:
   ```bash
   cp -r examples/ModuleTemplate Modules/<اسم_الوحدة>
   ```
2. استبدل جميع الأماكن التي يظهر فيها `ModuleName` باسم وحدتك الجديد.
3. حدّث ملف `composer.json` داخل الوحدة ليطابق مساحة الأسماء الجديدة ثم نفّذ:
   ```bash
   composer dump-autoload
   ```
4. أضف اسم الوحدة إلى `modules_statuses.json` أو فعّلها عبر أوامر Artisan:
   ```bash
   php artisan module:enable <اسم_الوحدة>
   ```

يساعد هذا القالب في البدء بوحدة جديدة مبنية على الهيكل القياسي للمشروع.
