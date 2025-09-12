<?php

namespace Modules\Membership\Tests\Unit;

use Illuminate\Support\Str;
use Modules\Membership\Http\Controllers\Api\PerkController;
use Modules\Membership\Models\MembershipPerk;
use Tests\TestCase;

class PerkApplierTest extends TestCase
{
    public function test_perks_retrieved_by_tier(): void
    {
        MembershipPerk::create([
            'tenant_id' => (string) Str::uuid(),
            'tier' => 'gold',
            'description' => 'Free drinks',
        ]);

        $controller = new PerkController();
        $response = $controller->show('gold');

        $this->assertContains('Free drinks', $response['perks']);
    }
}
