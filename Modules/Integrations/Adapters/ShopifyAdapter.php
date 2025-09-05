<?php

namespace Modules\Integrations\Adapters;

use App\DeliveryOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ShopifyAdapter
{
    protected string $baseUrl;
    protected string $token;
    protected int $retryAttempts;
    protected int $retryDelay;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.shopify.base_url'), '/');
        $this->token = (string) config('services.shopify.access_token');
        $this->retryAttempts = (int) config('services.shopify.retry_attempts', 3);
        $this->retryDelay = (int) config('services.shopify.retry_delay', 100);
    }

    public function syncOrders(): void
    {
        try {
            $orders = $this->fetchRecentOrders();

            foreach ($orders as $order) {
                $this->persistOrder($order);
            }
        } catch (Throwable $e) {
            Log::error('Shopify order sync failed: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Fetch recent orders from Shopify.
     *
     * @return array
     */
    protected function fetchRecentOrders(): array
    {
        $response = Http::withToken($this->token)
            ->retry($this->retryAttempts, $this->retryDelay)
            ->get($this->baseUrl . '/orders.json', [
                'status' => 'any',
                'limit' => 50,
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('Failed to fetch orders from Shopify: ' . $response->body());
        }

        return $response->json('orders') ?? [];
    }

    /**
     * Persist a single Shopify order into local models.
     */
    protected function persistOrder(array $order): void
    {
        DeliveryOrder::updateOrCreate(
            [
                'external_id' => $order['id'],
                'provider' => 'shopify',
            ],
            [
                'status' => $order['financial_status'] ?? 'pending',
            ]
        );
    }
}
