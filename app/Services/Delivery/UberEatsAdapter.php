<?php

namespace App\Services\Delivery;

use GuzzleHttp\Client;

class UberEatsAdapter implements DeliveryProvider
{
    protected Client $client;

    public function __construct(?Client $client = null)
    {
        $config = config('delivery.providers.ubereats');
        $this->client = $client ?: new Client([
            'base_uri' => $config['base_uri'] ?? '',
            'auth' => [$config['client_id'] ?? '', $config['client_secret'] ?? ''],
        ]);
    }

    public function createOrder(array $data): string
    {
        $response = $this->client->post('/orders', [
            'json' => $data,
        ]);

        $body = json_decode((string) $response->getBody(), true);

        return $body['id'] ?? '';
    }

    public function updateOrder(string $orderId, array $data): bool
    {
        $response = $this->client->put("/orders/{$orderId}", [
            'json' => $data,
        ]);

        return $response->getStatusCode() === 200;
    }
}
