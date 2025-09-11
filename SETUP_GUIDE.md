<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## Table of Contents

- [دليل إعداد موحد](#دليل-إعداد-موحد)
  - [إعداد البيئة](#إعداد-البيئة)
  - [بناء الكود](#بناء-الكود)
  - [تشغيل الخدمات](#تشغيل-الخدمات)
  - [النشر](#النشر)
  - [المتابعة](#المتابعة)
  - [روابط مرجعية](#روابط-مرجعية)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# دليل إعداد موحد

## إعداد البيئة
- تثبيت المتطلبات: PHP 8.4، Composer، Node.js 20+، Docker وDocker Compose، MySQL/Redis.
- استنساخ المستودع:
  ```bash
  git clone https://github.com/your-org/elitesaas.git
  cd elitesaas
  ```
- نسخ ملف الإعدادات وإنشاء المفتاح:
  ```bash
  cp .env.example .env
  php artisan key:generate
  ```

## بناء الكود
- تثبيت الاعتماديات:
  ```bash
  composer install
  npm install
  ```

## تشغيل الخدمات
- تشغيل الحاويات وتهيئة البيانات:
  ```bash
  docker-compose up -d    # أو docker compose up -d --build
  php artisan migrate --seed
  ```
- تشغيل الخادم وواجهة الاستخدام:
  ```bash
  php artisan serve
  npm run dev
  ```
- زيارة التطبيق على http://localhost:8000.

## النشر
- تخزين الأسرار في GitHub Actions أو أسرار Kubernetes مثل `STRIPE_KEY`, `DB_PASSWORD`, `SENTRY_DSN`.
- دفع التغييرات إلى الفرع `main` لتشغيل GitHub Actions.
- خط الأنابيب يقوم بـ: بناء الصورة وتشغيل الاختبارات ثم النشر إلى Kubernetes عبر Helm.

## المتابعة
- مراقبة الأخطاء عبر Sentry.
- جمع السجلات باستخدام ELK.
- متابعة المقاييس عبر Prometheus وGrafana.

## روابط مرجعية
- [README](README.md)
- [LOCAL_DEV](LOCAL_DEV.md)
- [DEPLOYMENT](DEPLOYMENT.md)
- [DEVOPS](DEVOPS.md)
