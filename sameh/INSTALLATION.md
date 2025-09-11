# INSTALLATION

## المتطلبات
- PHP 8.2 أو أحدث مع الامتدادات: mbstring, xml, curl, zip, sqlite, bcmath, gd, intl
- Composer
- Node.js 20 أو أحدث مع npm
- Git
- قاعدة بيانات SQLite أو MySQL

## الخطوات الأساسية
1. استنساخ المستودع وتشغيله:
```bash
git clone <URL>/cafeos.git
cd cafeos
```
2. إنشاء ملف البيئة:
```bash
cp .env.example .env
```
3. تثبيت الاعتمادات:
```bash
composer install
npm ci
```
4. توليد مفتاح التطبيق:
```bash
php artisan key:generate
```
5. إعداد قاعدة بيانات SQLite بسيطة:
```bash
mkdir -p database && touch database/database.sqlite
php artisan migrate --seed
```
6. تشغيل بيئة التطوير:
```bash
npm run dev
php artisan serve
```

## ملاحظات إضافية
- استخدم `php artisan migrate:fresh --seed` لإعادة تهيئة البيانات أثناء التطوير.
- لا تقم برفع ملف `.env` إلى نظام التحكم بالنسخ.
- يمكن تعديل إعدادات قواعد البيانات أو الخدمات من خلال ملف `.env`.
