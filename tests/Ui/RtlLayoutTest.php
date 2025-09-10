<?php

namespace Tests\Ui;

use Tests\TestCase;

class RtlLayoutTest extends TestCase
{
    public function test_rtl_layout_placeholder(): void
    {
        $this->markTestSkipped('RTL layout rendering requires browser environment.');
    }
}
