فّذ بالترتيب، وأبلغني بأي blockers فورًا.
المرحلة 1: إعداد البيئة والأساسيات

أنشئ مشروع Laravel 12 جديد: composer create-project laravel/laravel restaurant-saas-platform "12.*".
أضف الـ dependencies الرئيسية: composer require stancl/tenancy nwidart/laravel-modules spatie/laravel-permission filament/filament inertiajs/inertia-laravel laravel/sanctum owenit/auditing pusher/pusher-php-server.
أضف frontend dependencies: npm install @inertiajs/vue3 vue@3 tailwindcss postcss autoprefixer pinia.
شغّل الأوامر الأساسية: php artisan key:generate && php artisan storage:link && php artisan tenancy:install.
أنشئ docker-compose.yml كالتالي (PHP 8.3, MySQL 8, Redis, Nginx):
textversion: '3'
services:
  app: image: php:8.3-fpm; volumes: - .:/var/www; depends_on: - mysql - redis;
  mysql: image: mysql:8; environment: MYSQL_ROOT_PASSWORD=root MYSQL_DATABASE=central_db;
  redis: image: redis:alpine;
  nginx: image: nginx:alpine; ports: - "8000:80"; volumes: - .:/var/www - ./nginx.conf:/etc/nginx/conf.d/default.conf;

شغّل Docker: docker-compose up -d && php artisan migrate --path=database/migrations/central.
فعّل Telescope: php artisan telescope:install.

Best Practice: استخدم Redis للـ sessions per-tenant في .env: SESSION_DRIVER=redis.
تحذير: لا تنسَ --path=central في migrations؛ يسبب conflicts في DBs.
توسع: أضف GitHub Actions workflow لـ CI: test on push.
المرحلة 2: بناء Multi-Tenancy Core

أنشئ migration لـ tenants: php artisan make:migration create_tenants_table --path=database/migrations/central مع fields: id, name, domain, plan_type.
في app/Models/Tenant.php: أضف use HasDatabase, HasDomains; من stancl/tenancy.
أنشئ middleware: php artisan make:middleware InitializeTenancyByDomain – حدد tenant عبر domain وinitialize.
سجّل middleware في bootstrap/app.php: ->withMiddleware(fn(Middleware $middleware) => $middleware->alias(['tenancy' => InitializeTenancyByDomain::class])).
في config/tenancy.php: فعّل 'features' => ['database', 'redis', 'queue'], 'central_domains' => ['localhost'].

Best Practice: أضف tenant_id foreign key في كل tenant model مع indexing.
تحذير: تحقق tenancy()->initialized قبل queries في central DB.
توسع: شارد DBs لـ enterprise tenants via tenancy features.
المرحلة 3: إعداد Modular Architecture مع Toggle

نشر config: php artisan vendor:publish --tag=modules-config.
في config/modules.php: أضف 'modules' => ['Pos' => ['enabled' => true], 'Inventory' => ['enabled' => true], 'Crm' => ['enabled' => false]].
أنشئ Core module: php artisan module:make Core.
أنشئ Pos module: php artisan module:make Pos.
أنشئ command لـ toggle: php artisan make:command ToggleModule مع الكود:
php// app/Console/Commands/ToggleModule.php
class ToggleModule extends Command
{
    protected $signature = 'module:toggle {name} {status}';
    public function handle(): int
    {
        $module = $this->argument('name');
        $status = $this->argument('status') === 'enable';
        config(["{$module}_MODULE_ENABLED", $status]);
        if ($status) { Modules::enable($module); $this->call('migrate', ['--path' => "Modules/{$module}/Database/Migrations"]); }
        else { Modules::disable($module); $this->call('route:clear'); }
        return 0;
    }
}

في app/Providers/ModuleServiceProvider.php: boot loop لـ check config وenable/disable؛ سجّل في bootstrap/providers.php.

Best Practice: استخدم Modules::isEnabled('Pos') في routes لـ conditional loading.
تحذير: Clear caches عند toggle: php artisan cache:clear --tags=module-*.
توسع: دمج Pennant لـ granular feature flags داخل modules.
المرحلة 4: Authentication وRBAC

إعداد Filament: php artisan filament:install --panels && php artisan make:filament-user.
نشر permissions: php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider".
في app/Models/User.php: أضف use HasRoles; addGlobalScope('tenant', fn($q) => $q->where('tenant_id', tenant('id')));.
أنشئ policy: php artisan make:policy TenantPolicy --model=Tenant.
في routes: Route::middleware(['auth:sanctum', 'tenancy', 'role:owner'])->group(...);.

Best Practice: Bind module-specific roles مثل 'use-pos'.
تحذير: لا تستخدم Auth دون tenancy init.
توسع: JWT لـ API؛ Fortify لـ 2FA.
المرحلة 5: الموديلات والـ Migrations per Module

أنشئ Inventory module: php artisan module:make Inventory.
في Pos: php artisan make:model MenuItem -m وmigration لـ orders:
php// Modules/Pos/Database/Migrations/create_orders_table.php
Schema::create('orders', function (Blueprint $table) {
    $table->id(); $table->foreignId('tenant_id'); $table->decimal('total', 10, 2);
    $table->enum('status', ['pending', 'completed']); $table->timestamps(); $table->softDeletes();
    $table->index('tenant_id');
});

أضف relationships وSoftDeletes في models؛ auditing via OwenIt.

Best Practice: Eager loading؛ FIFO في Inventory.
تحذير: Indexes على tenant_id إلزامي.
توسع: Elasticsearch لـ search.
المرحلة 6: Core Modules والترابط عبر EDA

أنشئ Crm module: php artisan module:make Crm.
Event في Core: php artisan make:event OrderCreated.
في Pos Controller: event(new OrderCreated($order, tenant()));.
Listener في Inventory: php artisan make:listener UpdateInventory --event=OrderCreated مع:
php// Modules/Inventory/Listeners/UpdateInventory.php
public function handle(OrderCreated $event): void
{
    if (!Modules::isEnabled('Inventory')) { \Log::warning('Fallback: No stock update'); return; }
    $service = app(InventoryServiceInterface::class);
    $service->deductStock($event->order->items);
}

Contract في Core: interface InventoryServiceInterface { public function deductStock($items); } – implement/bind في Inventory.
Routes في Pos: if (Modules::isEnabled('Pos')) { Route::apiResource('orders', OrderController::class); }.

Best Practice: Queue events؛ DB transactions.
تحذير: تجنب circular events.
توسع: Kafka لـ cross-service EDA.
المرحلة 7: Frontend وUI

في resources/js/app.js: setup Inertia + Pinia.
Vue component لـ Pos Dashboard:
vue<!-- resources/js/Pages/Pos/Dashboard.vue -->
<template><div class="p-4"><h1>POS Dashboard</h1><div v-if="isInventoryEnabled">Stock: {{ stock }}</div></template>
<script setup>import { usePage } from '@inertiajs/vue3'; const { props } = usePage(); const isInventoryEnabled = props.isInventoryEnabled; </script>

Filament resource: php artisan make:filament-resource Modules/Pos/OrderResource.

Best Practice: Echo لـ real-time.
تحذير: Sanitize props.
توسع: PWA lazy-loading.
المرحلة 8: Testing

Test toggle: php artisan make:test ModuleToggleTest – assert enable/disable.
Event test: Event::fake(); dispatch(new OrderCreated(...)); Event::assertDispatched(UpdateInventory::class, false);.

Best Practice: 80% coverage؛ per-module tests.
تحذير: RefreshDatabase لـ isolation.
توسع: Load testing مع Artillery.
المرحلة 9: Deployment

Prep: php artisan optimize && php artisan queue:table && php artisan migrate.
Deploy via Forge؛ Docker production.yml مع module env vars.
CI/CD: GitHub Actions – test/deploy on main.

Best Practice: Zero-downtime؛ backups.
تحذير: HTTPS + rate limiting.
توسع: Kubernetes؛ Sentry.
المرحلة 10: Maintenance

Monitor via Telescope/Horizon.
Custom command: php artisan module:update Pos لـ updates.

Best Practice: Monthly audits.
تحذير: Backup قبل toggles.
توسع: Cashier لـ subscriptions؛ microservices migration.
