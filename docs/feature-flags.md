# Feature Flags

EliteSaaS relies on [Laravel Pennant](https://laravel.com/docs/pennant) to
toggle modules and beta features. Flags may be global or scoped to a specific
tenant.

## Management

Super admins can manage flags from the **Flags** resource in the Filament
panel. Each record maps a `module`, an optional `tenant_id` and an `enabled`
state.

```bash
PATCH /api/v1/admin/modules/{module} { "enabled": true }
```

Whenever a flag is updated the `admin.module.toggled@v1` domain event is
broadcast so other services can react.

