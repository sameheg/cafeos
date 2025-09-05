<?php

namespace Tests\Feature;

use Tests\TestCase;

class PurchasesTest extends TestCase
{
    public function test_purchases_route_requires_authentication()
    {
        $response = $this->get('/purchases');
        $response->assertStatus(302);
    }
}
