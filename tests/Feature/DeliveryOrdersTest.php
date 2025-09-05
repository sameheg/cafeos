<?php

namespace Tests\Feature;

use App\DeliveryProviderCredential;
use App\Jobs\SyncDeliveryOrders;
use App\Services\Delivery\DeliveryProvider;
use App\Services\Delivery\TalabatAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_fetched_orders()
    {
        $provider = new class implements DeliveryProvider {
            public function fetchOrders(): array
            {
                return [
                    ['id' => 'order-1', 'status' => 'pending'],
                ];
            }

            public function updateOrderStatus(string $orderId, string $status): bool
            {
                return true;
            }
        };

        $this->app->bind(TalabatAdapter::class, fn () => $provider);

        (new SyncDeliveryOrders('talabat'))->handle();

        $this->assertDatabaseHas('delivery_orders', [
            'external_id' => 'order-1',
            'provider' => 'talabat',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function it_prefers_database_credentials_over_env()
    {
        config()->set('delivery.providers.talabat.client_id', 'env-id');
        config()->set('delivery.providers.talabat.client_secret', 'env-secret');

        DeliveryProviderCredential::create([
            'provider' => 'talabat',
            'business_id' => null,
            'token' => 'db-id',
            'secret' => 'db-secret',
        ]);

        $provider = new class implements DeliveryProvider {
            public function fetchOrders(): array
            {
                return [];
            }

            public function updateOrderStatus(string $orderId, string $status): bool
            {
                return true;
            }
        };

        $this->app->bind(TalabatAdapter::class, fn () => $provider);

        (new SyncDeliveryOrders('talabat'))->handle();

        $this->assertEquals('db-id', config('delivery.providers.talabat.client_id'));
        $this->assertEquals('db-secret', config('delivery.providers.talabat.client_secret'));
    }
}
