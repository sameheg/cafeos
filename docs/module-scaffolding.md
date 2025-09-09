# Module Scaffolding

The `module:make` Artisan command now scaffolds a module with key components ready for development:

- **Database migration** including a `tenant_id` column for multi-tenancy.
- **Eloquent model** with `tenant_id` in `$fillable`.
- **Bilingual translation files** under `Resources/lang/en` and `Resources/lang/ar` with sample entries.
- **Feature test** stub for isolated testing.
- **`modules_statuses.json` entry** registering the module disabled by default.

Example:

```bash
php artisan module:make Blog
```

This generates the components above and updates `modules_statuses.json` with the new module disabled by default.
