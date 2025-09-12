<?php

namespace Modules\ArMenu\Tests\Unit;

use Modules\ArMenu\Services\FallbackDetector;
use Tests\TestCase;

class FallbackDetectorTest extends TestCase
{
    public function test_detects_weak_device(): void
    {
        $detector = new FallbackDetector();
        $this->assertTrue($detector->isWeakDevice(['memory' => 256, 'cpu' => 1]));
        $this->assertFalse($detector->isWeakDevice(['memory' => 1024, 'cpu' => 4]));
    }
}
