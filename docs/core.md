# Core Module

The Core module provides multi-tenancy, RBAC, event bus, feature flags and theming.

```mermaid
stateDiagram-v2
    [*] --> Resolved
    Resolved --> Authorized: check_rbac()
    Authorized --> EventEmitted: emit()
    Authorized --> Denied: fail_auth()
```

Example of emitting an event:

```php
EventBus::emit('core.tenant.resolved@v1', ['tenant_id' => $tenantId]);
```
