<?php

namespace Modules\Integrations\Adapters;

use App\DeliveryOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WooCommerceAdapter
{
    protected string $baseUrl;
    protected string $consumerKey;
    protected string $consumerSecret;
    protected int $retryAttempts;
    protected int $retryDelay;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.woocommerce.base_url'), '/');
        $this->consumerKey = (string) config('services.woocommerce.consumer_key');
        $this->consumerSecret = (string) config('services.woocommerce.consumer_secret');
        $this->retryAttempts = (int) config('services.woocommerce.retry_attempts', 3);
        $this->retryDelay = (int) config('services.woocommerce.retry_delay', 100);
    }

    public function syncOrders(): void
    {
        try {
            $orders = $this->fetchRecentOrders();

            foreach ($orders as $order) {
                $this->persistOrder($order);
            }
        } catch (Throwable $e) {
            Log::error('WooCommerce order sync failed: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Fetch recent orders from WooCommerce.
     */
    protected function fetchRecentOrders(): array
    {
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->retry($this->retryAttempts, $this->retryDelay)
            ->get($this->baseUrl . '/orders', [
                'per_page' => 50,
                'orderby' => 'date',
                'order' => 'desc',
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('Failed to fetch orders from WooCommerce: ' . $response->body());
        }

        return $response->json() ?? [];
    }

    /**
     * Persist a single WooCommerce order into local models.
     */
    protected function persistOrder(array $order): void
    {
        DeliveryOrder::updateOrCreate(
            [
                'external_id' => $order['id'] ?? null,
                'provider' => 'woocommerce',
            ],
            [
                'status' => $order['status'] ?? 'pending',
                'transaction_id' => $order['transaction_id'] ?? null,
            ]
        );
    }
}
