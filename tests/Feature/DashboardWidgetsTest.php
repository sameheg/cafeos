<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardWidgetsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');
        parent::setUp();
    }

    public function test_widget_order_is_persisted_and_rendered()
    {
        $user = User::create([
            'surname' => 'Mr',
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($user);

        $order = ['product-count', 'customer-count', 'total-sales', 'total-purchases', 'sales-chart'];

        $this->post('/dashboard/widgets-order', ['widgets' => $order])
            ->assertStatus(200);

        $this->assertEquals($order, $user->fresh()->dashboard_widgets);

        $response = $this->get('/dashboard');
        $response->assertSeeInOrder([
            'Products:',
            'Customers:',
            'Total Sales:',
            'Total Purchases:',
        ]);
    }
}
