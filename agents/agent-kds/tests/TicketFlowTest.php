<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/TicketEndpoint.php';
require_once __DIR__ . '/../src/AuthService.php';
require_once __DIR__ . '/../src/Roles.php';

final class TicketFlowTest extends TestCase
{
    public function testTicketBroadcastToDisplay(): void
    {
        $service = new KdsService();
        $auth = new AuthService('secret');
        $endpoint = new TicketEndpoint($service, $auth);
        $token = $auth->generateToken(Roles::CHEF);
        $received = null;
        $service->registerDisplay(function (array $ticket) use (&$received): void {
            $received = $ticket;
        });

        $ticket = [
            'id' => 1,
            'items' => [
                ['name' => 'Espresso', 'qty' => 1],
            ],
        ];

        $response = $endpoint->handle($ticket, $token);

        $this->assertSame($ticket, $received, 'Display should receive the ticket');
        $this->assertSame(['status' => 'accepted', 'ticket' => $ticket], $response);
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

