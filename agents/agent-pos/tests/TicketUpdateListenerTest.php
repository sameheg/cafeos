<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class TicketUpdateListenerTest extends TestCase
{
    public function testListenerOutputsUpdate(): void
    {
        $payload = json_encode([
            'event' => 'kds.ticket.update',
            'ticket' => ['id' => 42, 'status' => 'changed'],
        ]);

        $output = shell_exec("echo '$payload' | node agents/agent-pos/src/listener.js");
        $this->assertStringContainsString('POS received update for ticket 42', $output);
    }
}
