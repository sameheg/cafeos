<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Modules\Core\Http\Middleware\ResolveTenant;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class TenantResolverTest extends TestCase
{
    public function test_tenant_resolves_by_subdomain(): void
    {
        $tenant = Tenant::create(['name' => 'Acme', 'subdomain' => 'acme']);

        $middleware = new ResolveTenant();
        $request = Request::create('http://acme.test', 'GET', [], [], [], ['HTTP_HOST' => 'acme.test']);

        $middleware->handle($request, fn() => response('ok'));

        $this->assertEquals($tenant->id, app('tenant')->id);
    }
}
