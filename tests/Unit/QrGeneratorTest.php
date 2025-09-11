<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Qr\Models\QrCode;
use Tests\TestCase;

class QrGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_qr_code_has_url(): void
    {
        $qr = QrCode::create([
            'tenant_id' => 'tenant',
            'table_id' => 'table1',
            'url' => 'https://example.com/qr/table1',
            'generated_at' => now(),
        ]);

        $this->assertNotEmpty($qr->url);
    }
}
