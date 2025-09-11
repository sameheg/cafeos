<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tenant Model
    |--------------------------------------------------------------------------
    |
    | This class is used to store and retrieve tenants. It must extend the
    | Spatie\Multitenancy\Models\Tenant model.
    */
    'tenant_model' => App\Models\Tenant::class,

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */
    'tenant_database_connection_name' => 'tenant',
    'landlord_database_connection_name' => env('DB_CONNECTION', 'mysql'),

    /*
    | When true the package will automatically switch the DB connection after
    | a tenant has been identified.
    */
    'switch_database_after_tenant_resolved' => true,

    /*
    | Tenant Finder
    |--------------------------------------------------------------------------
    */
    'tenant_finder' => Spatie\Multitenancy\TenantFinder\DomainTenantFinder::class,

    /*
    | Storage paths for tenants
    */
    'storage' => [
        'disk' => 'local',
        'root' => storage_path('app/tenants/{id}'),
    ],

    /*
    | Queue
    |--------------------------------------------------------------------------
    */
    'queues_are_tenant_aware_by_default' => true,
];
