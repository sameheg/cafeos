<?php

namespace Modules\ArMenu\Tests\Feature;

use Modules\ArMenu\Models\ArAsset;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function test_can_view_asset_via_api(): void
    {
        $asset = ArAsset::factory()->create();
        $response = $this->getJson('/api/v1/ar/menu/'.$asset->id);
        $response->assertOk()->assertJson(['asset_url' => $asset->url]);
    }
}
