<?php

namespace Tests\Feature;

use Tests\TestCase;

class SalesTest extends TestCase
{
    public function test_sales_route_requires_authentication()
    {
        $response = $this->get('/sells');
        $response->assertStatus(302);
    }
}
