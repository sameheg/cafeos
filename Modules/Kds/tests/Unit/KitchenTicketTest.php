<?php

namespace Modules\Kds\Tests\Unit;

use Modules\Kds\Models\KitchenTicket;
use Tests\TestCase;

class KitchenTicketTest extends TestCase
{
    public function test_status_color_mapping()
    {
        $ticket = new KitchenTicket(['status' => 'cooking']);
        $this->assertEquals('orange', $ticket->status_color);
    }
}
