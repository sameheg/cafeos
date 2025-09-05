<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/KdsMetrics.php';
require_once __DIR__ . '/../src/Ticket.php';
require_once __DIR__ . '/../src/AuthService.php';
require_once __DIR__ . '/../src/Roles.php';
require_once __DIR__ . '/../src/TicketEndpoint.php';

final class TicketEndpointTest extends TestCase
{
    public function testHandleReturnsAcceptedResponse(): void
    {
        $service = new KdsService(new KdsMetrics());
        $auth = new AuthService('secret');
        $endpoint = new TicketEndpoint($service, $auth);
        $token = $auth->generateToken(Roles::CHEF);
        $ticket = ['id' => 5, 'items' => [['name' => 'Americano', 'qty' => 1]]];

        $response = $endpoint->handle($ticket, $token);

        $this->assertSame('accepted', $response['status']);
        $this->assertSame($ticket['id'], $response['ticket']['id']);
        $this->assertSame($ticket['items'], $response['ticket']['items']);
    }

    public function testHandlePropagatesServiceExceptions(): void
    {
        $service = $this->createMock(KdsService::class);
        $service->expects($this->once())
            ->method('receiveTicket')
            ->willThrowException(new RuntimeException('failure'));

        $auth = new AuthService('secret');
        $endpoint = new TicketEndpoint($service, $auth);
        $token = $auth->generateToken(Roles::CHEF);
        $ticket = ['id' => 6, 'items' => [['name' => 'Cappuccino', 'qty' => 1]]];

        $this->expectException(RuntimeException::class);
        $endpoint->handle($ticket, $token);
    }
}
