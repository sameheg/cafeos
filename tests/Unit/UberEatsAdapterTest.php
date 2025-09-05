<?php

namespace Tests\Unit;

use App\Services\Delivery\UberEatsAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class UberEatsAdapterTest extends TestCase
{
    public function test_fetch_orders_returns_array()
    {
        config(['delivery.providers.ubereats' => [
            'client_id' => 'id',
            'client_secret' => 'secret',
            'base_uri' => 'https://ubereats.test',
        ]]);

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                ['id' => '1', 'status' => 'pending'],
            ])),
        ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $adapter = new UberEatsAdapter($client);
        $orders = $adapter->fetchOrders();

        $this->assertEquals('1', $orders[0]['id']);
    }

    public function test_update_order_status_returns_true_on_success()
    {
        config(['delivery.providers.ubereats' => [
            'client_id' => 'id',
            'client_secret' => 'secret',
            'base_uri' => 'https://ubereats.test',
        ]]);

        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $adapter = new UberEatsAdapter($client);
        $result = $adapter->updateOrderStatus('1', 'delivered');

        $this->assertTrue($result);
    }
}
