<?php

namespace Tests\Feature\Restaurant;

use Tests\TestCase;

class KitchenDisplayTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_kitchen_display_page_loads()
    {
        $response = $this->get('/modules/kitchen-display');
        $response->assertStatus(200);
        $response->assertSee('initTimers');
    }
}
