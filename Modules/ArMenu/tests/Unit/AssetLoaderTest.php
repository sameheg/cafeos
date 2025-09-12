<?php

namespace Modules\ArMenu\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Modules\ArMenu\Events\ArMenuViewed;
use Modules\ArMenu\Models\ArAsset;
use Tests\TestCase;

class AssetLoaderTest extends TestCase
{
    public function test_mark_viewed_dispatches_event(): void
    {
        Event::fake();
        $asset = ArAsset::factory()->make();
        $asset->markViewed('ar');
        Event::assertDispatched(ArMenuViewed::class);
    }
}
