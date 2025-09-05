<?php

namespace App\Services\Delivery;

use GuzzleHttp\Client;

class TalabatAdapter implements DeliveryProvider
{
    protected Client $client;

    public function __construct(?Client $client = null)
    {
        $config = config('delivery.providers.talabat');
        $this->client = $client ?: new Client([
            'base_uri' => $config['base_uri'] ?? '',
            'auth' => [$config['client_id'] ?? '', $config['client_secret'] ?? ''],
        ]);
    }

    public function fetchOrders(): array
    {
        $response = $this->client->get('/orders');
        return json_decode((string) $response->getBody(), true);
    }

    public function updateOrderStatus(string $orderId, string $status): bool
    {
        $response = $this->client->post("/orders/{$orderId}/status", [
            'json' => ['status' => $status],
        ]);

        return $response->getStatusCode() === 200;
    }
}
