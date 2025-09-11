<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Qr\Models\QrCode;
use Tests\TestCase;

class MenuLoaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_endpoint_returns_menu(): void
    {
        QrCode::create([
            'tenant_id' => 'tenant',
            'table_id' => 'table1',
            'url' => 'https://example.com/qr/table1',
            'generated_at' => now(),
        ]);

        $response = $this->getJson('/v1/qr/menu/table1');
        $response->assertStatus(200)->assertJsonStructure(['menu']);
    }
}
