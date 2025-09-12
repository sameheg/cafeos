# FloorPlanDesigner Module

Interactive floor plan designer with zones, versioning, and heatmaps.

## Features
- CRUD for Floorplans & Zones
- Versioning (draft → versioned → archived)
- Heatmap endpoint (`GET /api/v1/floorplan/heatmap/{plan}`)
- Filament admin: manage plans, bulk publish/archive
- Tenant-aware policies (RBAC stubs)
- Events: `floorplan.updated@v1` emitted on updates
- Observers wired, factories for testing

## Install
1. Enable the module in your platform.
2. Run migrations:
   ```bash
   php artisan migrate
   ```
3. (Optional) Seed demo data:
   ```bash
   php artisan db:seed --class=Modules\FloorPlanDesigner\Database\Seeders\FloorPlanDesignerSeeder
   ```

## API
- `PATCH /api/v1/floorplan/{plan}` — update plan JSON (`json_data` array)
- `GET /api/v1/floorplan/heatmap/{plan}` — return heatmap data (feature-flagged)

## Config
`config/floorplandesigner.php`:
```php
return [
  'feature_flags' => [
    'floorplan_heatmaps' => env('FF_FLOORPLAN_HEATMAPS', true),
  ],
];
```

## Security / RBAC
Map your platform permissions to the following ability strings:
- `floorplan.view`, `floorplan.create`, `floorplan.update`, `floorplan.delete`
- `floorplan.zone.view`, `floorplan.zone.create`, `floorplan.zone.update`, `floorplan.zone.delete`

## Tests
Factories provided for rapid test setup.


## Admin (Filament)
- Resource: Floorplan (CRUD, publish/archive/schedule)
- Relation Manager: Zones (nested CRUD)
- Pages: FloorplanDesigner (interactive canvas)

## CLI
- `php artisan floorplan:export {id}`
- `php artisan floorplan:import {file}`

## Background Jobs
- `Modules\FloorPlanDesigner\Jobs\GenerateHeatmap` — يحسب/يولد بيانات heatmap ويحفظها في `json_data.heatmap`

## OpenAPI
- docs/openapi.yaml — تعريفات الـ endpoints لاستخدام Scribe/Swagger لاحقًا.

## Routes
- API Prefix: `/api/v1/floorplan`
- Designer UI: صفحة Filament تحت slug: `floorplan-designer` (أضف ?id=<plan-id> لفتح خطة معينة).

## Permissions
Seeder اختياري لإنشاء صلاحيات Spatie Permission إن متاحة.

## ملاحظات
- كل الأكواد مكتفية ذاتيًا داخل الموديول.
- علاقات tenant يتم ضبطها عبر الـ policies.


## Pro Canvas Features
- Snap-to-grid, multi-select, grouping-lite
- Rotate/Scale fields (rotation handle + numeric controls)
- Layers panel (order, visibility via selection checkboxes)
- Properties panel (name/cap/status/x/y/w/h/r/layer)
- Undo/Redo
- Export SVG/PNG
- Palette: Table/Chair/Zone/Door/Bar
- Saves to `json_data.furniture`

### Serving the JS
- Quick path baked via API route: `GET /api/v1/floorplan/assets/pro-canvas.js`
- Or move assets into your app bundler (Vite) and reference the file accordingly.


## POS Integration
- Endpoint: `GET /api/v1/floorplan/{id}/tables` → returns mapped tables (furniture.type=table).
- Each table entry includes: `furniture_id`, `name`, `capacity`, `status`, `pos_table_id`.
- Use `pos_table_id` to link with POS module (`pos_tables`).


# Enterprise Edition

## Normalized Furniture (Source of Truth)
- جدول `floorplan_furniture` بدل JSON فقط.
- REST endpoints: 
  - `GET /api/v1/floorplan/{id}/furniture`
  - `POST /api/v1/floorplan/{id}/furniture` (create single)
  - `PATCH /api/v1/floorplan/{id}/furniture/{furniture}` (update)
  - `DELETE /api/v1/floorplan/{id}/furniture/{furniture}` (delete)
  - `POST /api/v1/floorplan/{id}/furniture/batch` (batch upsert من الـCanvas)

## Events (Broadcast)
- `floorplan.table.created@v1`, `floorplan.table.updated@v1`, `floorplan.table.deleted@v1`
- قناة: `tenant.{tenant_id}.floorplan` — جاهزة للـEcho/Pusher.

## Commands
- `php artisan floorplan:sync-import {plan}` → يستورد من JSON → DB
- `php artisan floorplan:sync-export {plan}` → يصدر من DB → JSON

## Policies / RBAC
- FurniturePolicy abilities: `floorplan.furniture.view/create/update/delete`

## Pro Canvas Integration
- الـCanvas بيقرأ من `/furniture` وبيحفظ عبر `/furniture/batch`.
- كل عنصر Table يحمل `pos_table_id` للربط مع POS.

## طريق الترقية من الإصدارات السابقة
1) شغّل المايجريشن الجديدة.
2) نفّذ: `php artisan floorplan:sync-import {plan}` لنقل بياناتك الموجودة.
3) افتح Pro Canvas واحفظ مرة لتأكيد التحويل.

## Realtime Overlay (Hook)
- استعمل Laravel Echo للاستماع لقناة `tenant.{tenant_id}.floorplan` وتحديث الـCanvas لايف.


## Enterprise+ Additions
- Columns: `qr_url`, `branch_id`, `floor_number`
- Overlay endpoint: `GET /api/v1/floorplan/{id}/overlay` (status-ready payload)
- POS Listeners: update furniture status on `pos.order.started` / `pos.order.closed` (wire events in your app)
- Command: `php artisan floorplan:generate-qr {plan} --base-url="https://yourapp/qr"`
- Stats: `floorplan_stats` + job `ComputeFloorplanStats` (placeholder to integrate with POS data)
- Filament Widget: `FloorplanKpi`
- Pro Canvas: polling overlay كل 5 ثواني وتلوين العناصر حسب الحالة
