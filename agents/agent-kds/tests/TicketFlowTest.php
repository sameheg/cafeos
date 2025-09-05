<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/KdsService.php';
require_once __DIR__ . '/../src/KdsServer.php';

final class TicketFlowTest extends TestCase
{
    public function testHttpAndWebSocketFlow(): void
    {
        $service = new KdsService();
        $server = new KdsServer($service);

        $messages = [];
        $server->connectWebSocket(function (string $msg) use (&$messages): void {
            $messages[] = json_decode($msg, true);
        });

        $ticket = [
            'id' => 1,
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
}
