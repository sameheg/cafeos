<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

it('resolves tenant by domain', function () {
    $tenant = Tenant::create([
        'name' => 'Test',
        'domain' => 'example.com',
        'database' => 'tenant_example',
    ]);

    $resolved = Tenant::whereDomain('example.com')->first();
    expect($resolved->id)->toBe($tenant->id);
});

it('switches database per tenant', function () {
    $tenant = Tenant::first();
    $tenant->makeCurrent();
    expect(config('database.connections.tenant.database'))->toBe($tenant->database);
});
