<?php

namespace Modules\Kiosk\Tests\Unit;

use Tests\TestCase;

class TouchEventTest extends TestCase
{
    public function test_view_contains_touch_event(): void
    {
        $html = view('kiosk::kiosk')->render();
        $this->assertStringContainsString('touchstart', $html);
    }
}
