<?php

namespace Modules\SuperAdmin\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Modules\SuperAdmin\Models\Flag;
use Tests\TestCase;

class FlagToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_enable_module_when_dependency_missing(): void
    {
        config(['module-dependencies.Kds' => ['Pos']]);

        $kds = Flag::create(['module' => 'Kds', 'tenant_id' => null, 'enabled' => false]);

        $this->expectException(ValidationException::class);

        $kds->update(['enabled' => true]);

        $this->assertFalse($kds->fresh()->enabled);
    }

    public function test_enables_when_dependency_present(): void
    {
        config(['module-dependencies.Kds' => ['Pos']]);

        Flag::create(['module' => 'Pos', 'tenant_id' => null, 'enabled' => true]);
        $kds = Flag::create(['module' => 'Kds', 'tenant_id' => null, 'enabled' => false]);

        $kds->update(['enabled' => true]);

        $this->assertTrue($kds->fresh()->enabled);
    }
}
