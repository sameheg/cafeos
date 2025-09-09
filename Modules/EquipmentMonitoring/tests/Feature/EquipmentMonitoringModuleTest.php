<?php

namespace Modules\EquipmentMonitoring\Tests\Feature;

use App\Http\Middleware\SetUserLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\EquipmentMonitoring\Models\Device;
use Tests\TestCase;

class EquipmentMonitoringModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(SetUserLocale::class);
    }

    public function test_reading_triggers_alert(): void
    {
        $device = Device::create([
            'name' => 'Fridge 1',
            'temperature_threshold' => 5,
        ]);

        $response = $this->postJson("/equipment-monitoring/devices/{$device->id}/readings", [
            'temperature' => 10,
            'status' => 'ok',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('alerts', [
            'device_id' => $device->id,
        ]);
    }
}
