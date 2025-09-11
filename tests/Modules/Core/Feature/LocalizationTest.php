<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_locale_from_tenant(): void
    {
        Tenant::create(['name' => 'Acme', 'slug' => 'acme', 'locale' => 'ar']);

        $response = $this->withHeader('X-Tenant', 'acme')->get('/v1/healthz');

        $response->assertJson([
            'status' => 'ok',
            'message' => 'حسناً',
        ]);
    }
}
