<?php

return [
    'tenant_model' => App\Models\Tenant::class,

    'tenant_database_connection_name' => 'tenant',

    'switch_tenant_tasks' => [
        Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask::class,
        Spatie\Multitenancy\Tasks\PrefixCacheTask::class,
    ],

    'tenant_artisan_search_fields' => ['id', 'domain'],

    'tenant_storage_disk' => 'tenant',

    'landlord_connection_name' => env('DB_CONNECTION', 'mysql'),
];
