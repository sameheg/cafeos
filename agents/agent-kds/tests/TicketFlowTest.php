<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Ticket.php';
require_once __DIR__ . '/../src/KdsMetrics.php';
require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/TicketEndpoint.php';
require_once __DIR__ . '/../src/AuthService.php';
require_once __DIR__ . '/../src/Roles.php';
require_once __DIR__ . '/../src/KdsServer.php';

final class TicketFlowTest extends TestCase
{
    public function testTicketStatusFlowAndBroadcast(): void
    public function testHttpAndWebSocketFlow(): void
    {
        $service = new KdsService(new KdsMetrics());
        $service = new KdsService();
        $auth = new AuthService('secret');
        $endpoint = new TicketEndpoint($service, $auth);
        $token = $auth->generateToken(Roles::CHEF);
        $received = null;

        $server = new KdsServer($service);

        $messages = [];
        $server->connectWebSocket(function (string $msg) use (&$messages): void {
            $messages[] = json_decode($msg, true);
        });
        $endpoint = new TicketEndpoint($service);
        $received = [];
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received[] = $ticket;
        });
            $received = $ticket;
        }, 'bar');

        $ticket = [
            'id' => 1,
            'station' => 'bar',
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $post = $server->handleRequest('POST', '/tickets', $ticket);
        $get = $server->handleRequest('GET', '/tickets/active');

        $this->assertSame(201, $post['status']);
        $this->assertSame(['status' => 'accepted', 'ticket' => $ticket], $post['body']);

        // First message is the initial active list, second is the broadcast for the new ticket
        $this->assertSame('ticket.created', $messages[1]['type']);
        $this->assertSame($ticket, $messages[1]['ticket']);

        $this->assertSame([$ticket], $get['body']['tickets']);
    }

    public function testTicketFilteredByStation(): void
    {
        $service = new KdsService();
        $endpoint = new TicketEndpoint($service);
        $receivedBar = null;
        $receivedGrill = null;
        $service->registerDisplay(function (array $ticket) use (&$receivedBar): void {
            $receivedBar = $ticket;
        }, 'bar');
        $service->registerDisplay(function (array $ticket) use (&$receivedGrill): void {
            $receivedGrill = $ticket;
        }, 'grill');

        $ticket = [
            'id' => 2,
            'station' => 'bar',
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $endpoint->handle($ticket);

        $this->assertSame($ticket, $receivedBar);
        $this->assertNull($receivedGrill);
    }

    public function testStationAssignedFromSettings(): void
    {
        $service = new KdsService(['Espresso' => 'bar']);
        $endpoint = new TicketEndpoint($service);
        $received = null;
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received = $ticket;
        }, 'bar');

        $ticket = [
            'id' => 3,
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $response = $endpoint->handle($ticket, $token);
        $response = $endpoint->handle($ticket);
        $this->assertSame('accepted', $response['status']);
        $this->assertSame('pending', $received[0]['status']);
        $this->assertArrayHasKey('pending', $received[0]['timestamps']);

        $endpoint->update(1, Ticket::STATUS_PREPARING);
        $this->assertSame('preparing', $received[1]['status']);
        $this->assertArrayHasKey('preparing', $received[1]['timestamps']);

        $this->assertArrayHasKey('received_at', $received);
        unset($received['received_at']);
        $this->assertSame($ticket, $received, 'Display should receive the ticket');
        $this->assertSame(['status' => 'accepted', 'ticket' => $ticket], $response);
        $endpoint->update(1, Ticket::STATUS_READY);
        $this->assertSame('ready', $received[2]['status']);
        $this->assertNotNull($received[2]['preparation_time']);

        $endpoint->update(1, Ticket::STATUS_SERVED);
        $this->assertSame('served', $received[3]['status']);
        $this->assertArrayHasKey('served', $received[3]['timestamps']);
        $endpoint->handle($ticket);

        $this->assertSame('bar', $received['station']);
    }

    public function testRejectsInvalidToken(): void
    {
        $service = new KdsService();
        $auth = new AuthService('secret');
        $endpoint = new TicketEndpoint($service, $auth);

        $this->expectException(RuntimeException::class);
        $endpoint->handle(['id' => 1], 'invalid.token');
    }
}

