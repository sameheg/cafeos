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
    public function test_create_order_returns_id()
    {
        config(['delivery.providers.ubereats' => [
            'client_id' => 'id',
            'client_secret' => 'secret',
            'base_uri' => 'https://ubereats.test',
        ]]);

        $mock = new MockHandler([
            new Response(201, [], json_encode(['id' => '1'])),
        ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $adapter = new UberEatsAdapter($client);
        $id = $adapter->createOrder(['item' => 'coffee']);

        $this->assertEquals('1', $id);
    }

    public function test_update_order_returns_true_on_success()
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
        $result = $adapter->updateOrder('1', ['status' => 'delivered']);

        $this->assertTrue($result);
    }
}
