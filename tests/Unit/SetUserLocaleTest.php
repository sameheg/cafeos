<?php

namespace Tests\Unit;

use App\Http\Middleware\SetUserLocale;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Tests\TestCase;

class SetUserLocaleTest extends TestCase
{
    public function test_defaults_to_tenant_locale(): void
    {
        $tenant = new Tenant(['id' => 't1', 'name' => ['en' => 'Tenant'], 'locale' => 'ar']);
        app()->instance('tenant', $tenant);

        $middleware = new SetUserLocale;
        $request = Request::create('/', 'GET');
        $session = app('session')->driver();
        $request->setLaravelSession($session);
        $session->start();

        $middleware->handle($request, fn () => null);

        $this->assertSame('ar', app()->getLocale());

        app()->forgetInstance('tenant');
    }

    public function test_query_parameter_overrides_locale(): void
    {
        $tenant = new Tenant(['id' => 't1', 'name' => ['en' => 'Tenant'], 'locale' => 'ar']);
        app()->instance('tenant', $tenant);

        $middleware = new SetUserLocale;
        $request = Request::create('/', 'GET', ['lang' => 'fr']);
        $session = app('session')->driver();
        $request->setLaravelSession($session);
        $session->start();

        $middleware->handle($request, fn () => null);

        $this->assertSame('fr', app()->getLocale());
        $this->assertSame('fr', session('locale'));

        app()->forgetInstance('tenant');
    }
}
