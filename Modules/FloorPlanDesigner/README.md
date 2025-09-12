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
