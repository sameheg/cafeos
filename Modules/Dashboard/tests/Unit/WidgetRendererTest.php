<?php

namespace Modules\Dashboard\Tests\Unit;

use Modules\Dashboard\Services\WidgetRenderer;
use PHPUnit\Framework\TestCase;

class WidgetRendererTest extends TestCase
{
    public function test_renders_widgets(): void
    {
        $renderer = new WidgetRenderer();
        $out = $renderer->render(['chart']);
        $this->assertEquals('chart', $out[0]['widget']);
    }
}
