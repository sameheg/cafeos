<?php

namespace Tests\Feature\Kds;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Kds\Models\KdsTicket;
use Tests\TestCase;

class TicketCompletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_lifecycle(): void
    {
        $response = $this->postJson('/api/v1/kds/tickets', [
            'order_id' => 'order-1',
        ]);

        $ticketId = $response->json('ticket_id');

        $this->assertDatabaseHas('kds_tickets', [
            'id' => $ticketId,
            'status' => KdsTicket::STATUS_PENDING,
        ]);

        $this->patchJson("/api/v1/kds/tickets/{$ticketId}/bump")
            ->assertOk()
            ->assertJson(['completed' => true]);

        $this->assertDatabaseHas('kds_tickets', [
            'id' => $ticketId,
            'status' => KdsTicket::STATUS_COMPLETED,
        ]);
    }
}
