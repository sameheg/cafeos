<?php

namespace Modules\EquipmentMaintenance\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\EquipmentMaintenance\Enums\TicketStatus;
use Modules\EquipmentMaintenance\Models\MaintenanceTicket;
use Tests\TestCase;

class CompleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_can_be_completed(): void
    {
        $ticket = MaintenanceTicket::create([
            'tenant_id' => 't1',
            'equipment_id' => 'eq1',
            'priority' => 3,
            'status' => TicketStatus::Scheduled,
        ]);

        $response = $this->patchJson('/api/v1/maintenance/tickets/'.$ticket->id.'/complete');

        $response->assertOk()->assertJson(['completed' => true]);

        $this->assertEquals(TicketStatus::Completed, $ticket->fresh()->status);
    }
}
