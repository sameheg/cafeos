<?php

namespace Modules\EquipmentLeasing\Tests\Unit;

use Modules\EquipmentLeasing\Services\DamageReporter;
use Modules\EquipmentLeasing\Models\EquipmentLease;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Mockery;

class DamageReporterTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_damage_event_dispatched(): void
    {
        Event::fake();
        $lease = Mockery::mock(EquipmentLease::class);
        $lease->shouldReceive('getAttribute')->with('id')->andReturn('1');
        $lease->shouldReceive('reportDamage')->once();

        $reporter = new DamageReporter();
        $reporter->report($lease, 'broken');

        Event::assertDispatched('equipment.damage.reported@v1', function ($event, $payload) {
            return $payload['lease_id'] === '1' && $payload['details'] === 'broken';
        });
    }
}

